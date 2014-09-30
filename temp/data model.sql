/* 
Lay danh sach tat ca category trong he thong
*/
Select a.term_id, a.`name`
from wp_terms a
inner join wp_term_taxonomy b on a.term_id = b.term_id
where b.taxonomy = 'category';
/*
Lay ra tat ca bai viet trong category 11
*/
Select *
from wp_posts a
inner join wp_term_relationships b on a.ID = b.object_id
inner join wp_term_taxonomy c on b.term_taxonomy_id = c.term_taxonomy_id
where c.term_id = 12;

/*
Lay ra tat ca category la con cua category game-ONLINE
*/
select *
from wp_terms a
inner join wp_term_taxonomy b on a.term_id = b.term_id
where b.taxonomy = 'category' and b.parent = 15;
/*
Lay danh sach subcategory from database taigametop
*/


INSERT INTO wordpress.wp_terms(name)
Select a.subcategoryname
from taigametop.subcategory a
inner join taigametop.category b on a.categoryid = b.categoryid
where b.categoryid = 5;