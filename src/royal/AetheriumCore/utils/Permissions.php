<?php
namespace royal\AetheriumCore\utils;


final class Permissions{

    public static array $permissionsall = [
		self::vanish,
		self::PERMISSIONS,
		self::CRAFT,
		self::ENDERCHEST,
        self::MONNAIE,
        self::ADMIN,
        self::HOME_MAITRE,
        self::HOME_ELITE,
        self::HOME_ELITE,
        self::HOME_VETERANT,
        self::HOME_PRO,
	];

	///staff\\\
	public const vanish = "vanish.use";
    public const ADMIN = "admin.use";
	public const PERMISSIONS = "permissions.use";
    public const MONNAIE = "monnaie.use";
    public const ADMIN_HOME = "home.use";
    public const LOGS_BLOCK = "log.use";
	///rank\\\
	public const CRAFT = "craft.use";
	public const ENDERCHEST = "endechest.use";

    public const HOME_PRO = "home.pro+";
    public const HOME_VETERANT = "home.veterant";
    public const HOME_ELITE = "home.elite";
    public const HOME_MAITRE = "home.maitre";


	public static array $permissionsRank = [
		self::vanish,
		self::PERMISSIONS
	];
	public static array $permissionsAdmin = [
		self::vanish,
		self::PERMISSIONS
	];
}