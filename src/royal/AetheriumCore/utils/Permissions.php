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
	];

	///staff\\\
	public const vanish = "vanish.use";
    public const ADMIN = "admin.use";
	public const PERMISSIONS = "permissions.use";
    public const MONNAIE = "monnaie.use";
	///rank\\\
	public const CRAFT = "craft.use";
	public const ENDERCHEST = "endechest.use";
	public static array $permissionsRank = [
		self::vanish,
		self::PERMISSIONS
	];
	public static array $permissionsAdmin = [
		self::vanish,
		self::PERMISSIONS
	];
}