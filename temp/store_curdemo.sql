DROP PROCEDURE IF EXISTS curdemo;
CREATE PROCEDURE curdemo(p_categoryId INT, p_wpCatId Int)
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE catName VARCHAR(200); DECLARE catSub VARCHAR(300);DECLARE maxId BIGINT;
  DECLARE cat CURSOR FOR 
	SELECT subcategoryname, subcategorydes
	From taigametop.subcategory Where categoryid = p_categoryId;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cat;
  read_loop: LOOP
    FETCH cat INTO catName, catSub;
    IF done THEN
      LEAVE read_loop;
    END IF;
    INSERT INTO wordpress.wp_terms(name,slug)
		VALUES(catName,catName);
		Select max(term_id) INTO maxId
		From wordpress.wp_terms;		

		INSERT INTO wordpress.wp_term_taxonomy(term_id, taxonomy, description,parent)
		VALUES(maxId,'category',catSub,p_wpCatId);

  END LOOP;

  CLOSE cat;
END;
