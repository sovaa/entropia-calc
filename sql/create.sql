create table weaponenhancer(
    id int not null auto_increment primary key,
    name varchar(64) not null,
    points int,
    socket int not null,
    damage double,
    `range` double,
    accuracy double,
    skill double,
    economy double,
    tt double,
    markup varchar(32),
    source varchar(32),
    discovered varchar(32)
);

create table amp(
    id int not null auto_increment primary key,
    name varchar(64) not null,
    decay double not null default 1,
    damage double not null default 1,
    burn int not null default 0,
    type varchar(32) not null
);

create table attachment(
    id int not null auto_increment primary key,
    name varchar(64) not null,
    decay double not null default 0,
    skillmod double not null default 0,
    skillbonus double not null default 0,
    critchance double not null default 0,
    critdamage double not null default 0,
    zoom int not null default 0,
    type varchar(32) not null,
    markup double not null
);

create table creature(
    id int not null auto_increment primary key,
    name varchar(64) not null,
    hp int not null,
    regen double not null,
    damage double,
    threat double,
    maturity int not null
);

create table weapon(
    id int not null auto_increment primary key,
    class varchar(32),
    type varchar(32),
    name varchar(128),
    damage double not null default 1,
    `range` double not null default 1,
    markup double not null default 100,
    decay double,
    burn double,
    attacks double not null default 1,
    hitrec double,
    hitmax double,
    dmgrec double,
    dmgmax double,
    hitprof double,
    dmgprof double,
    sib int not null default 0,
    source varchar(32),
    weight double,
    power double,
    mintt double,
    maxtt double,
    uses double,
    discovered varchar(32),
    found varchar(32),
    dmgstb double,
    dmgcut double,
    dmgimp double,
    dmgpen double,
    dmgshr double,
    dmgbrn double,
    dmgcld double,
    dmgacd double,
    dmgelc double
);


