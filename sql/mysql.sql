CREATE TABLE multieditor_editors (
	multied_id int(11) NOT NULL auto_increment,
	multied_name text NOT NULL,
	multied_class text NOT NULL,
	multied_path text NOT NULL,
	multied_weight int(11) NOT NULL default '0',
	multied_default bool NOT NULL default '0',
	multied_isnew bool NOT NULL default '0',
	PRIMARY KEY (multied_id)
) TYPE=MyISAM;

CREATE TABLE multieditor_groups_modules_array (
	multigm_id int(11) NOT NULL auto_increment,
	multigm_group_id int(11) NOT NULL,
	multigm_module_id int(11) NOT NULL,
	multigm_editor_id int (11) NOT NULL,
	multigm_textarea text NOT NULL,
	PRIMARY KEY (multigm_id)
) TYPE=MyISAM;

-- 
-- Dumping data for table 'multieditor_editors'
-- 

INSERT INTO multieditor_editors (multied_id,multied_name,multied_class,multied_path,multied_weight,multied_default)
	VALUES ('', 'default', '', '', '0', '1');
