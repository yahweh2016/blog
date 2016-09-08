cate_id

cate_name

cate_title
cate_keywords
cate_
cate_view

cate_order

cate_pid

create table blog_category(
  cate_id int unsigned primary key auto_increment comment'分类id',
  cate_name VARCHAR (50) not null DEFAULT '' comment '分类名称',
  cate_title VARCHAR (255) not null DEFAULT '' comment '分类说明',
  cate_keywords VARCHAR (255) not null DEFAULT '' comment '关键词',
  cate_description VARCHAR (255) not null DEFAULT ''comment '描述',
  cate_view int not null DEFAULT 0 comment '查看次数',
  cate_order tinyint not null DEFAULT 0 comment '排序',
  cate_pid int not null DEFAULT 0 comment '父类id',
  index `desc` (cate_description),
  index `order`(cate_order),
  index `view`(cate_view),
  index `keywords`(cate_keywords),
  index `name`(cate_name),
)charset=utf8 engine=myisam;