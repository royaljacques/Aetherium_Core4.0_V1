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
        self::HOME_LEGENDE,
        self::HOME_ELITE,
        self::HOME_VIP,
        self::HOME_ULTRA,
        self::HOME_VIPP,
	];

	///staff\\\
	public const vanish = "vanish.use";
    public const ADMIN = "admin.use";
	public const PERMISSIONS = "permissions.use";
    public const MONNAIE = "monnaie.use";
    public const ADMIN_HOME = "home.use";
	///rank\\\
	public const CRAFT = "craft.use";
	public const ENDERCHEST = "endechest.use";


    public const HOME_VIP = "home.vip";
    public const HOME_VIPP = "home.vip+";
    public const HOME_ULTRA = "home.ultra";
    public const HOME_ELITE = "home.elite";
    public const HOME_LEGENDE = "home.legende";


	public static array $permissionsRank = [
		self::vanish,
		self::PERMISSIONS
	];
	public static array $permissionsAdmin = [
		self::vanish,
		self::PERMISSIONS
	];
}