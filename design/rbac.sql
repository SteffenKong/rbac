create database  if not exists rbac charset=utf8;

use rbac;

-- 管理员表
create table if not exists monda_admin(
    id mediumint unsigned not null auto_increment,
    account varchar(191) not null comment '账号',
    password varchar(191) not null comment '密码',
    nick_name varchar(191) not null comment '真实姓名',
    email varchar(191) not null comment '邮箱',
    phone varchar(191) not null comment '手机',
    status tinyint default 1 comment '状态 0 - 禁用 1 - 启用',
    role_id mediumint unsigned comment '角色id 角色id为0代表是超级管理员',
    created_at datetime  comment '创建时间',
    updated_at datetime  comment '修改时间',
    primary key (id),
    unique key uk_account(account),
    unique key uk_nick_name(nick_name),
    unique key uk_email(email),
    unique key uk_phone(phone),
    index idx_role_id (role_id),
    index idx_status (status)
)charset=utf8,engine=innodb;

INSERT INTO `monda_admin`(account,password,nick_name,email,phone,status,role_id) VALUES ('SteffenKong','$2y$10$CKYcOw..M0vQwnEurUi8heyzCFhpinOgYG2NmV/K5LbBx5taVXPRi','孔浩源','3266023724@qq.com','15622903410',1,0);



-- 角色表
create table if not exists monda_roles(
    id mediumint unsigned not null auto_increment,
    role_name varchar(191) not null comment '角色名称',
    description text comment '角色描述',
    status tinyint default 1 comment '角色状态 0 - 禁用  1 - 启用',
    created_at int not null comment '创建时间',
    updated_at int not null comment '修改时间',
    primary key(id),
    unique key uk_role_name (role_name),
    index idx_status (status)
)charset=utf8,engine=innodb;


-- 角色 - 权限 中间表
create table if not exists monda_permission_role(
    id mediumint unsigned not null auto_increment,
    role_id mediumint unsigned not null comment '角色id',
    permission_id mediumint unsigned not null comment '权限id',
    created_at int not null comment '创建时间',
    updated_at int not null comment '修改时间',
    primary key (id),
    index idx_role_id (role_id),
    index idx_permission_id (permission_id)
)charset=utf8,engine=innodb;


-- 权限表
create table if not exists monda_permissions(
    id mediumint unsigned not null auto_increment,
    permission_name varchar(191) not null comment '权限名称',
    url  varchar(191) not null comment '权限路由',
    pid mediumint unsigned default 0 comment '父级id',
    created_at int not null comment '创建时间',
    updated_at int not null comment '修改时间',
    primary key(id),
    unique key uk_permission_name (permission_name),
    unique key uk_url (url)
)charset=utf8,engine=innodb;