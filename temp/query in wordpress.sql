-- select all tags
select b.name as tag_name, b.term_id as tag_id
from wp_term_taxonomy a
inner join wp_terms b on a.term_id = b.term_id
where taxonomy = 'post_tag';
-- select all category
select b.name as cat_name, b.term_id as cat_id
from wp_term_taxonomy a
inner join wp_terms b on a.term_id = b.term_id
where taxonomy = 'category';
-- select number posts of tag 'vo lam mobile'
select b.count
from wp_terms a
inner join wp_term_taxonomy b on a.term_id = b.term_id
where `name` = 'vo lam mobile';
-- select all post of tag 'vo lam mobile'
select a.*
from wp_posts a
inner join wp_term_relationships b on a.id = b.object_id
inner join wp_term_taxonomy c on b.term_taxonomy_id = c.term_taxonomy_id
inner join wp_terms d on c.term_id = d.term_id
where c.taxonomy = 'post_tag' 
			and d.`name` = 'vo lam mobile';
-- slect number post of cat 'Game Bài - Casino'
select a.count
from wp_term_taxonomy a
inner join wp_terms b on a.term_id = b.term_id
where a.taxonomy = 'category' and b.`name` = 'Game Bài - Casino';
-- select all post of cat 'Game Bài - Casino'
select *
from wp_posts a
inner join wp_term_relationships b on a.ID = b.object_id
inner join wp_term_taxonomy c on b.term_taxonomy_id = c.term_taxonomy_id
inner join wp_terms d on c.term_id = d.term_id
where c.taxonomy = 'category' and d.`name` = 'Game Bài - Casino';