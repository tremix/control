/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     02/06/2014 04:46:06 p.m.                     */
/*==============================================================*/

drop schema if exists dhocompe_intranet; create schema dhocompe_intranet; use dhocompe_intranet;

drop table if exists ACCION;

drop table if exists ACTIVIDAD;

drop table if exists ADICIONAL;

drop table if exists ADICIONAL_PROYECTO;

drop table if exists ALERTA;

drop table if exists CARGO;

drop table if exists CLIENTE;

drop table if exists CODIGO_POSTAL;

drop table if exists CONTACTO;

drop table if exists CONTROL;

drop table if exists DEPARTAMENTO;

drop table if exists DIRECCION;

drop table if exists DISTRITO;

drop table if exists ETAPA;

drop table if exists FORMULARIO;

drop table if exists LEIDO_ALERTA;

drop table if exists MONEDA;

drop table if exists NIVEL;

drop table if exists PAIS;

drop table if exists PERMISO;

drop table if exists PROPUESTA;

drop table if exists PROVINCIA;

drop table if exists PROYECTO;

drop table if exists PROYECTO_ACTIVIDAD;

drop table if exists PROYECTO_ETAPA;

drop table if exists RESPONSABLE;

drop table if exists ROL;

drop table if exists RUBRO;

drop table if exists SEGUIMIENTO;

drop table if exists SITUACION;

drop table if exists TIPO_AREA;

drop table if exists TIPO_PROPUESTA;

drop table if exists TIPO_SERVICIO;

drop table if exists USUARIO;

drop table if exists VALOR_HORA;

/*==============================================================*/
/* Table: ACCION                                                */
/*==============================================================*/
create table ACCION
(
   ID_ACCION            int not null auto_increment,
   NOM_ACCION           varchar(50),
   primary key (ID_ACCION)
);

/*==============================================================*/
/* Table: ACTIVIDAD                                             */
/*==============================================================*/
create table ACTIVIDAD
(
   ID_ACTIVIDAD         int not null auto_increment,
   ID_ETAPA             int,
   NOMBRE_ACTIVIDAD     varchar(1000),
   primary key (ID_ACTIVIDAD)
);

/*==============================================================*/
/* Table: ADICIONAL                                             */
/*==============================================================*/
create table ADICIONAL
(
   ID_ADICIONAL         int not null auto_increment,
   NOMBRE_ADICIONAL     varchar(500),
   primary key (ID_ADICIONAL)
);

/*==============================================================*/
/* Table: ADICIONAL_PROYECTO                                    */
/*==============================================================*/
create table ADICIONAL_PROYECTO
(
   ID_ADICIONAL_PROYECTO int not null auto_increment,
   ID_PROYECTO          int,
   ID_ADICIONAL         int,
   ID_USUARIO           int,
   COSTO_ADICIONAL_PROYECTO decimal(18,2),
   COMENTARIO_ADICIONAL_PROYECTO varchar(500),
   FECHA_ADICIONAL_PROYECTO date,
   FECHA_CREACION       date,
   primary key (ID_ADICIONAL_PROYECTO)
);

/*==============================================================*/
/* Table: ALERTA                                                */
/*==============================================================*/
create table ALERTA
(
   ID_ALERTA            int not null auto_increment,
   ID_USUARIO           int,
   ID_ROL               int,
   CONTE_ALERTA         varchar(500),
   LINK_ALERTA          varchar(300),
   NOMLINK_ALERTA       varchar(50),
   FECH_ALERTA          datetime,
   FECH_CREA            datetime,
   USU_CREA             int,
   primary key (ID_ALERTA)
);

/*==============================================================*/
/* Table: CARGO                                                 */
/*==============================================================*/
create table CARGO
(
   ID_CARGO             int not null auto_increment,
   NOM_CARGO            varchar(150),
   primary key (ID_CARGO)
);

/*==============================================================*/
/* Table: CLIENTE                                               */
/*==============================================================*/
create table CLIENTE
(
   ID_CLIENTE           int not null auto_increment,
   ID_RUBRO             int,
   CORRE_CLIENTE        int,
   COD_CLIENTE          varchar(10),
   RAZSOC_CLIENTE       varchar(500),
   NOMCOM_CLIENTE       varchar(500),
   RUC_CLIENTE          varchar(11),
   NROEMP_CLIENTE       int,
   WEB_CLIENTE          varchar(500),
   EST_CLIENTE          char(1),
   FECH_CREA            datetime,
   FECH_EDITA           datetime,
   USU_CREA             int,
   USU_EDITA            int,
   primary key (ID_CLIENTE)
);

/*==============================================================*/
/* Table: CODIGO_POSTAL                                         */
/*==============================================================*/
create table CODIGO_POSTAL
(
   ID_CODIGO_POSTAL     int not null auto_increment,
   NOM_CODIGO_POSTAL    varchar(100),
   COD_CODIGO_POSTAL    varchar(50),
   primary key (ID_CODIGO_POSTAL)
);

/*==============================================================*/
/* Table: CONTACTO                                              */
/*==============================================================*/
create table CONTACTO
(
   ID_CONTACTO          int not null auto_increment,
   ID_CLIENTE           int,
   NOM_CONTACTO         varchar(50),
   APE_CONTACTO         varchar(100),
   CARGO_CONTACTO       varchar(150),
   EMAIL_CONTACTO       varchar(300),
   TFIJO_CONTACTO       varchar(20),
   TDIREC_CONTACTO      varchar(20),
   TCEL1_CONTACTO       varchar(20),
   TCEL2_CONTACTO       varchar(20),
   OBS_CONTACTO         varchar(500),
   PRINC_CONTACTO       bool,
   FECH_CREA            datetime,
   FECH_EDITA           datetime,
   USU_CREA             int,
   USU_EDITA            int,
   primary key (ID_CONTACTO)
);

/*==============================================================*/
/* Table: CONTROL                                               */
/*==============================================================*/
create table CONTROL
(
   ID_CONTROL           int not null auto_increment,
   ID_PROYECTO          int,
   ID_ACTIVIDAD         int,
   ID_USUARIO           int,
   HORAS_IMPUTADAS_CONTROL decimal(18,2),
   SITUACION_CONTROL    char(1),
   OBSERVACIONES_CONTROL varchar(1000),
   ES_REPROCESO_CONTROL bool,
   POR_CLIENTE_CONTROL  bool,
   FECHA_CONTROL        date,
   ACTUAL_COSTO_HORA_CONSULTOR_CONTROL decimal(18,2),
   FECHA_CREACION       date,
   primary key (ID_CONTROL)
);

/*==============================================================*/
/* Table: DEPARTAMENTO                                          */
/*==============================================================*/
create table DEPARTAMENTO
(
   ID_DEPARTAMENTO      int not null auto_increment,
   ID_PAIS              int,
   NOM_DEPARTAMENTO     varchar(50),
   primary key (ID_DEPARTAMENTO)
);

/*==============================================================*/
/* Table: DIRECCION                                             */
/*==============================================================*/
create table DIRECCION
(
   ID_DIRECCION         int not null auto_increment,
   ID_CLIENTE           int,
   ID_DISTRITO          int,
   ID_CODIGO_POSTAL     int,
   ID_PAIS              int,
   ID_DEPARTAMENTO      int,
   ID_PROVINCIA         int,
   CONTE_DIRECCION      varchar(250),
   URB_DIRECCION        varchar(200),
   REF_DIRECCION        varchar(500),
   PRINC_DIRECCION      bool,
   FECH_CREA            datetime,
   FECH_EDITA           datetime,
   USU_CREA             int,
   USU_EDITA            int,
   primary key (ID_DIRECCION)
);

/*==============================================================*/
/* Table: DISTRITO                                              */
/*==============================================================*/
create table DISTRITO
(
   ID_DISTRITO          int not null auto_increment,
   ID_PROVINCIA         int,
   NOM_DISTRITO         varchar(50),
   primary key (ID_DISTRITO)
);

/*==============================================================*/
/* Table: ETAPA                                                 */
/*==============================================================*/
create table ETAPA
(
   ID_ETAPA             int not null auto_increment,
   ID_TIPO_SERVICIO     int,
   NOMBRE_ETAPA         varchar(200),
   primary key (ID_ETAPA)
);

/*==============================================================*/
/* Table: FORMULARIO                                            */
/*==============================================================*/
create table FORMULARIO
(
   ID_FORMULARIO        int not null auto_increment,
   NOM_FORMULARIO       varchar(50),
   LINK_FORMULARIO      varchar(300),
   primary key (ID_FORMULARIO)
);

/*==============================================================*/
/* Table: LEIDO_ALERTA                                          */
/*==============================================================*/
create table LEIDO_ALERTA
(
   ID_LEIDO_ALERTA      int not null auto_increment,
   ID_ALERTA            int,
   ID_USUARIO           int,
   FECH_CREA            datetime,
   primary key (ID_LEIDO_ALERTA)
);

/*==============================================================*/
/* Table: MONEDA                                                */
/*==============================================================*/
create table MONEDA
(
   ID_MONEDA            int not null auto_increment,
   NOM_MONEDA           varchar(100),
   SIMB_MONEDA          varchar(5),
   primary key (ID_MONEDA)
);

/*==============================================================*/
/* Table: NIVEL                                                 */
/*==============================================================*/
create table NIVEL
(
   ID_NIVEL             int not null auto_increment,
   NOM_NIVEL            varchar(150),
   DEPEN_NIVEL          int,
   primary key (ID_NIVEL)
);

/*==============================================================*/
/* Table: PAIS                                                  */
/*==============================================================*/
create table PAIS
(
   ID_PAIS              int not null auto_increment,
   NOM_PAIS             varchar(50),
   primary key (ID_PAIS)
);

/*==============================================================*/
/* Table: PERMISO                                               */
/*==============================================================*/
create table PERMISO
(
   ID_PERMISO           int not null auto_increment,
   ID_USUARIO           int,
   ID_ROL               int,
   ID_FORMULARIO        int,
   PERMI_FORMULARIO     varchar(10),
   FECH_CREA            datetime,
   FECH_EDITA           datetime,
   USU_CREA             int,
   USU_EDITA            int,
   primary key (ID_PERMISO)
);

/*==============================================================*/
/* Table: PROPUESTA                                             */
/*==============================================================*/
create table PROPUESTA
(
   ID_PROPUESTA         int not null auto_increment,
   ID_CLIENTE           int,
   ID_USUARIO_COMERCIAL int,
   ID_USUARIO_TECNICO   int,
   ID_MONEDA            int,
   ID_TIPO_SERVICIO     int,
   ID_TIPO_AREA         int,
   ID_TIPO_PROPUESTA    int,
   ID_SITUACION         int,
   CORRE_PROPUESTA      int,
   COD_PROPUESTA        varchar(10),
   VAR_PROPUESTA        varchar(50),
   FECH_PROPUESTA       date,
   COMI_PROPUESTA       bool,
   LICI_PROPUESTA       bool,
   PORC_PROPUESTA       decimal(18,2),
   DESCR_PROPUESTA      varchar(1000),
   MONTO_PROPUESTA      decimal(18,2),
   FECHESTI_PROPUESTA   date,
   EST_PROPUESTA        char(1),
   FECH_CREA            datetime,
   FECH_EDITA           datetime,
   USU_CREA             int,
   USU_EDITA            int,
   primary key (ID_PROPUESTA)
);

/*==============================================================*/
/* Table: PROVINCIA                                             */
/*==============================================================*/
create table PROVINCIA
(
   ID_PROVINCIA         int not null auto_increment,
   ID_DEPARTAMENTO      int,
   NOM_PROVINCIA        varchar(50),
   primary key (ID_PROVINCIA)
);

/*==============================================================*/
/* Table: PROYECTO                                              */
/*==============================================================*/
create table PROYECTO
(
   ID_PROYECTO          int not null auto_increment,
   ID_PROPUESTA         int,
   COSTO_HORA_PROYECTO  decimal(18,2),
   ES_FACTURABLE_PROYECTO bool,
   ESTADO_PROYECTO      char(1),
   FECHA_CREACION       datetime,
   FECHA_EDICION        datetime,
   USUARIO_CREACION     int,
   USUARIO_EDICION      int,
   primary key (ID_PROYECTO)
);

/*==============================================================*/
/* Table: PROYECTO_ACTIVIDAD                                    */
/*==============================================================*/
create table PROYECTO_ACTIVIDAD
(
   ID_PROYECTO_ACTIVIDAD int not null auto_increment,
   ID_PROYECTO          int,
   ID_ACTIVIDAD         int,
   FECHA_INICIO_PROYECTO_ACTIVIDAD date,
   FECHA_FINAL_PROYECTO_ACTIVIDAD date,
   HORAS_ASIGNADAS_PROYECTO_ACTIVIDAD decimal(18,2),
   primary key (ID_PROYECTO_ACTIVIDAD)
);

/*==============================================================*/
/* Table: PROYECTO_ETAPA                                        */
/*==============================================================*/
create table PROYECTO_ETAPA
(
   ID_PROYECTO_ETAPA    int not null auto_increment,
   ID_PROYECTO          int,
   ID_ETAPA             int,
   primary key (ID_PROYECTO_ETAPA)
);

/*==============================================================*/
/* Table: RESPONSABLE                                           */
/*==============================================================*/
create table RESPONSABLE
(
   ID_RESPONSABLE       int not null auto_increment,
   ID_PROYECTO          int,
   ID_USUARIO           int,
   primary key (ID_RESPONSABLE)
);

/*==============================================================*/
/* Table: ROL                                                   */
/*==============================================================*/
create table ROL
(
   ID_ROL               int not null auto_increment,
   NOM_ROL              varchar(50),
   EST_ROL              bool,
   primary key (ID_ROL)
);

/*==============================================================*/
/* Table: RUBRO                                                 */
/*==============================================================*/
create table RUBRO
(
   ID_RUBRO             int not null auto_increment,
   NOM_RUBRO            varchar(50),
   primary key (ID_RUBRO)
);

/*==============================================================*/
/* Table: SEGUIMIENTO                                           */
/*==============================================================*/
create table SEGUIMIENTO
(
   ID_SEGUIMIENTO       int not null auto_increment,
   ID_PROPUESTA         int,
   ID_ACCION            int,
   SIGAC_SEGUIMIENTO    datetime,
   COMEN_SEGUIMIENTO    varchar(1000),
   ALER_SEGUIMIENTO     bool,
   FECH_CREA            datetime,
   USU_CREA             int,
   primary key (ID_SEGUIMIENTO)
);

/*==============================================================*/
/* Table: SITUACION                                             */
/*==============================================================*/
create table SITUACION
(
   ID_SITUACION         int not null auto_increment,
   NOM_SITUACION        varchar(50),
   primary key (ID_SITUACION)
);

/*==============================================================*/
/* Table: TIPO_AREA                                             */
/*==============================================================*/
create table TIPO_AREA
(
   ID_TIPO_AREA         int not null auto_increment,
   ID_TIPO_PROPUESTA    int,
   NOM_TIPO_AREA        varchar(50),
   COD_TIPO_AREA        varchar(10),
   DESCR_TIPO_AREA      varchar(500),
   primary key (ID_TIPO_AREA)
);

/*==============================================================*/
/* Table: TIPO_PROPUESTA                                        */
/*==============================================================*/
create table TIPO_PROPUESTA
(
   ID_TIPO_PROPUESTA    int not null auto_increment,
   NOM_TIPO_PROPUESTA   varchar(50),
   COD_TIPO_PROPUESTA   varchar(10),
   DESCR_TIPO_PROPUESTA varchar(500),
   primary key (ID_TIPO_PROPUESTA)
);

/*==============================================================*/
/* Table: TIPO_SERVICIO                                         */
/*==============================================================*/
create table TIPO_SERVICIO
(
   ID_TIPO_SERVICIO     int not null auto_increment,
   ID_TIPO_AREA         int,
   NOM_TIPO_SERVICIO    varchar(50),
   COD_TIPO_SERVICIO    varchar(10),
   DESCR_TIPO_SERVICIO  varchar(500),
   primary key (ID_TIPO_SERVICIO)
);

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO
(
   ID_USUARIO           int not null auto_increment,
   ID_ROL               int,
   ID_CARGO             int,
   ID_NIVEL             int,
   NOM_USUARIO          varchar(50),
   APE_USUARIO          varchar(100),
   LOGIN_USUARIO        varchar(50),
   PASS_USUARIO         varchar(250),
   EMAIL_USUARIO        varchar(500),
   FECHNAC_USUARIO      datetime,
   SEX_USUARIO          char(1),
   EST_USUARIO          char(1),
   FECH_CREA            datetime,
   FECH_EDITA           datetime,
   USU_CREA             int,
   USU_EDITA            int,
   primary key (ID_USUARIO)
);

/*==============================================================*/
/* Table: VALOR_HORA                                            */
/*==============================================================*/
create table VALOR_HORA
(
   ID_VALOR_HORA        int not null auto_increment,
   ID_USUARIO           int,
   CANTIDAD_VALOR_HORA  decimal(18,2),
   primary key (ID_VALOR_HORA)
);

alter table ACTIVIDAD add constraint FK_REFERENCE_43 foreign key (ID_ETAPA)
      references ETAPA (ID_ETAPA) on delete restrict on update restrict;

alter table ADICIONAL_PROYECTO add constraint FK_REFERENCE_53 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table ADICIONAL_PROYECTO add constraint FK_REFERENCE_54 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table ADICIONAL_PROYECTO add constraint FK_REFERENCE_55 foreign key (ID_ADICIONAL)
      references ADICIONAL (ID_ADICIONAL) on delete restrict on update restrict;

alter table ALERTA add constraint FK_REFERENCE_24 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table ALERTA add constraint FK_REFERENCE_25 foreign key (ID_ROL)
      references ROL (ID_ROL) on delete restrict on update restrict;

alter table CLIENTE add constraint FK_REFERENCE_11 foreign key (ID_RUBRO)
      references RUBRO (ID_RUBRO) on delete restrict on update restrict;

alter table CONTACTO add constraint FK_REFERENCE_4 foreign key (ID_CLIENTE)
      references CLIENTE (ID_CLIENTE) on delete restrict on update restrict;

alter table CONTROL add constraint FK_REFERENCE_50 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table CONTROL add constraint FK_REFERENCE_51 foreign key (ID_ACTIVIDAD)
      references ACTIVIDAD (ID_ACTIVIDAD) on delete restrict on update restrict;

alter table CONTROL add constraint FK_REFERENCE_52 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table DEPARTAMENTO add constraint FK_REFERENCE_26 foreign key (ID_PAIS)
      references PAIS (ID_PAIS) on delete restrict on update restrict;

alter table DIRECCION add constraint FK_REFERENCE_10 foreign key (ID_CODIGO_POSTAL)
      references CODIGO_POSTAL (ID_CODIGO_POSTAL) on delete restrict on update restrict;

alter table DIRECCION add constraint FK_REFERENCE_28 foreign key (ID_PROVINCIA)
      references PROVINCIA (ID_PROVINCIA) on delete restrict on update restrict;

alter table DIRECCION add constraint FK_REFERENCE_29 foreign key (ID_DEPARTAMENTO)
      references DEPARTAMENTO (ID_DEPARTAMENTO) on delete restrict on update restrict;

alter table DIRECCION add constraint FK_REFERENCE_30 foreign key (ID_PAIS)
      references PAIS (ID_PAIS) on delete restrict on update restrict;

alter table DIRECCION add constraint FK_REFERENCE_5 foreign key (ID_CLIENTE)
      references CLIENTE (ID_CLIENTE) on delete restrict on update restrict;

alter table DIRECCION add constraint FK_REFERENCE_9 foreign key (ID_DISTRITO)
      references DISTRITO (ID_DISTRITO) on delete restrict on update restrict;

alter table DISTRITO add constraint FK_REFERENCE_8 foreign key (ID_PROVINCIA)
      references PROVINCIA (ID_PROVINCIA) on delete restrict on update restrict;

alter table ETAPA add constraint FK_REFERENCE_42 foreign key (ID_TIPO_SERVICIO)
      references TIPO_SERVICIO (ID_TIPO_SERVICIO) on delete restrict on update restrict;

alter table LEIDO_ALERTA add constraint FK_REFERENCE_31 foreign key (ID_ALERTA)
      references ALERTA (ID_ALERTA) on delete restrict on update restrict;

alter table LEIDO_ALERTA add constraint FK_REFERENCE_32 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table PERMISO add constraint FK_REFERENCE_21 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table PERMISO add constraint FK_REFERENCE_22 foreign key (ID_ROL)
      references ROL (ID_ROL) on delete restrict on update restrict;

alter table PERMISO add constraint FK_REFERENCE_23 foreign key (ID_FORMULARIO)
      references FORMULARIO (ID_FORMULARIO) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_12 foreign key (ID_CLIENTE)
      references CLIENTE (ID_CLIENTE) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_16 foreign key (ID_USUARIO_COMERCIAL)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_33 foreign key (ID_MONEDA)
      references MONEDA (ID_MONEDA) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_34 foreign key (ID_SITUACION)
      references SITUACION (ID_SITUACION) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_35 foreign key (ID_USUARIO_TECNICO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_36 foreign key (ID_TIPO_SERVICIO)
      references TIPO_SERVICIO (ID_TIPO_SERVICIO) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_39 foreign key (ID_TIPO_AREA)
      references TIPO_AREA (ID_TIPO_AREA) on delete restrict on update restrict;

alter table PROPUESTA add constraint FK_REFERENCE_40 foreign key (ID_TIPO_PROPUESTA)
      references TIPO_PROPUESTA (ID_TIPO_PROPUESTA) on delete restrict on update restrict;

alter table PROVINCIA add constraint FK_REFERENCE_27 foreign key (ID_DEPARTAMENTO)
      references DEPARTAMENTO (ID_DEPARTAMENTO) on delete restrict on update restrict;

alter table PROYECTO add constraint FK_REFERENCE_41 foreign key (ID_PROPUESTA)
      references PROPUESTA (ID_PROPUESTA) on delete restrict on update restrict;

alter table PROYECTO_ACTIVIDAD add constraint FK_REFERENCE_46 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table PROYECTO_ACTIVIDAD add constraint FK_REFERENCE_47 foreign key (ID_ACTIVIDAD)
      references ACTIVIDAD (ID_ACTIVIDAD) on delete restrict on update restrict;

alter table PROYECTO_ETAPA add constraint FK_REFERENCE_44 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table PROYECTO_ETAPA add constraint FK_REFERENCE_45 foreign key (ID_ETAPA)
      references ETAPA (ID_ETAPA) on delete restrict on update restrict;

alter table RESPONSABLE add constraint FK_REFERENCE_48 foreign key (ID_PROYECTO)
      references PROYECTO (ID_PROYECTO) on delete restrict on update restrict;

alter table RESPONSABLE add constraint FK_REFERENCE_49 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

alter table SEGUIMIENTO add constraint FK_REFERENCE_17 foreign key (ID_PROPUESTA)
      references PROPUESTA (ID_PROPUESTA) on delete restrict on update restrict;

alter table SEGUIMIENTO add constraint FK_REFERENCE_18 foreign key (ID_ACCION)
      references ACCION (ID_ACCION) on delete restrict on update restrict;

alter table TIPO_AREA add constraint FK_REFERENCE_38 foreign key (ID_TIPO_PROPUESTA)
      references TIPO_PROPUESTA (ID_TIPO_PROPUESTA) on delete restrict on update restrict;

alter table TIPO_SERVICIO add constraint FK_REFERENCE_37 foreign key (ID_TIPO_AREA)
      references TIPO_AREA (ID_TIPO_AREA) on delete restrict on update restrict;

alter table USUARIO add constraint FK_REFERENCE_1 foreign key (ID_ROL)
      references ROL (ID_ROL) on delete restrict on update restrict;

alter table USUARIO add constraint FK_REFERENCE_2 foreign key (ID_CARGO)
      references CARGO (ID_CARGO) on delete restrict on update restrict;

alter table USUARIO add constraint FK_REFERENCE_3 foreign key (ID_NIVEL)
      references NIVEL (ID_NIVEL) on delete restrict on update restrict;

alter table VALOR_HORA add constraint FK_REFERENCE_56 foreign key (ID_USUARIO)
      references USUARIO (ID_USUARIO) on delete restrict on update restrict;

