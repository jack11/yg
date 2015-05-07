/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2014/11/13 ปร 04:46:59 ปร                      */
/*==============================================================*/


drop table if exists admin;

drop table if exists auth;

drop table if exists category;

drop table if exists download;

drop table if exists information;

/*==============================================================*/
/* Table: admin                                                 */
/*==============================================================*/
create table admin
(
   id                   int not null auto_increment,
   name                 varchar(20),
   password             char(32),
   uptime               int,
   primary key (id)
);

/*==============================================================*/
/* Table: auth                                                  */
/*==============================================================*/
create table auth
(
   id                   int not null auto_increment,
   admin_id             int,
   category_id          int,
   primary key (id)
);

/*==============================================================*/
/* Table: category                                              */
/*==============================================================*/
create table category
(
   id                   int not null auto_increment,
   name                 varchar(20),
   description          varchar(200),
   parent_id            int,
   primary key (id)
);

/*==============================================================*/
/* Table: download                                              */
/*==============================================================*/
create table download
(
   id                   int not null auto_increment,
   admin_id             int,
   type                 smallint,
   file                 varchar(200),
   categry_id           int,
   primary key (id)
);

/*==============================================================*/
/* Table: information                                           */
/*==============================================================*/
create table information
(
   id                   int not null auto_increment,
   category_id          int,
   title                varchar(100),
   content              text,
   uptime               int,
   admin_id             int,
   count                int,
   primary key (id)
);

