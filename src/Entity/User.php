<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="acteur", type="string")
 * @ORM\DiscriminatorMap({"candidat"="Candidat", "entreprise"="Entreprise","admin"="Admin"})
 * @ORM\Table(name="users")
 * @Vich\Uploadable
 */
abstract class User implements UserInterface, \Serializable
{
    const ROLE_CANDIDAT     = "ROLE_CANDIDAT";
    const ROLE_RECRUTEUR    = "ROLE_RECRUTEUR";
    const ROLE_ADMIN        = "ROLE_ADMIN";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Veuillez saisir votre email")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min = 8 ,
     *  minMessage="Le mot de passe doit comporter au minimum 8 caractères")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @Vich\UploadableField(mapping="image_user", fileNameProperty="photoProfil")
     * @var File
     */
    private $photoProfilFile;

    //update pour gérer l'insertion des fichiers

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @var string|null
     */
    private $photoProfil;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
    //getters et setter de l'image

    /**
     * @return File
     */
    public function getPhotoProfilFile(): ?File
    {
        return $this->photoProfilFile;
    }

    /**
     * @param File $photoProfilFile
     * @return User
     * @throws \Exception
     */
    public function setPhotoProfilFile(File $photoProfilFile): User
    {
        $this->photoProfilFile = $photoProfilFile;
        if ($this->photoProfilFile instanceof UploadedFile) {
            $this->updateAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param mixed $updateAt
     * @return User
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    /**
     * @param string $photoProfil
     * @return User
     */
    public function setPhotoProfil(?string $photoProfil): User
    {
        $this->photoProfil = $photoProfil;
        return $this;
    }

    public function serialize()
    {

        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));

    }

    public function unserialize($serialized)
    {

        list (
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($serialized);
    }


}
