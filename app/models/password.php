<?php
namespace Models;

class Password {
    public int $passwordId;
    public string $websiteUrl;
    public string $email;
    public string $password;
    public int $fkUserId;
}