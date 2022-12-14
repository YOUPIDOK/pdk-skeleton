<?php

namespace App\Command\Tool;

use App\Entity\User\User;
use App\Enum\User\GenderEnum;
use App\Repository\User\GroupRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'user:create',
    description: 'User creation',
)]
class UserCreateCommand extends Command
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $userPasswordHasher;
    private GroupRepository $groupRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher,
        GroupRepository $groupRepository
    ){
        parent::__construct('user:create');
        $this->em = $em;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->groupRepository = $groupRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userRepo = $this->em->getRepository(User::class);

        $user = (new User())
            ->setFirstname($io->ask('Firstname '))
            ->setLastname($io->ask('Lastname '))
            ->setEmail($io->ask('E-mail ', null, function ($email) use ($userRepo) {
                if ($userRepo->findOneBy(['email' => $email]) !== null) {
                    throw new \RuntimeException('User already exist');
                }

                return $email;
            }))
            ->setGender($io->choice('Gender', GenderEnum::$genders, GenderEnum::MAN))
            ->setUpdatePasswordAt(new DateTime('now'))
            ->setEnabled($io->confirm('Enabled', false))
        ;

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $io->askHidden('Password')));

        if ($io->confirm('Is super admin ?', false)) {
            $user->addRole('ROLE_SUPER_ADMIN');
        }else{
            if ($io->confirm('Is admin ?', false)) {
                $user->addRole('ROLE_ADMIN');
            }
        }

        $addNewRole = $io->confirm('Other role ? ', false);
        while ($addNewRole) {
            $user->addRole($io->ask('Role ',''));
            $addNewRole = $io->confirm('Other role ?', false);
        }

        $addNewGroup = $io->confirm('Add group ? ', false);
        while ($addNewGroup) {

            $user->addGroup($io->choice('Group', $this->groupRepository->findAll()));
            $addNewGroup = $io->confirm('Other group ?', false);
        }

        $this->em->persist($user);
        $this->em->flush();

        $io->success($user->getIdentity() . ' has been generated.');

        return Command::SUCCESS;
    }
}
