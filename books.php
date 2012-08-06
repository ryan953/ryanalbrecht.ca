<?php
function books() {
	$books = array(
		//sorted
		array('name'=>'Code Complete'),
		array(
			'name'=>"Don't Make me Think",
			'done'=>true
		),
		array('name'=>'Mastering Regular Expressions'),
		array(
			'name'=>'Design Patterns',
			'done'=>true
		),
		array(
			'name'=>'Peopleware',
			'done'=>true
		),
		array('name'=>'Programming Pearls'),
		array('name'=>'Algorithm Design Manual'),
		array(
			'name'=>'Pragmatic Programmer',
			'done'=>true
		),
		array(
			'name'=>'Mythical Man Month',
			'done'=>true
		),
		array('name'=>'Structure and Interpretation of Computer Programs'),
		array('name'=>'Concepts Techniques'),
		array('name'=>'Models of Computer Programming'),
		array('name'=>'Art of Computer Programming'),
		array('name'=>'Database systems , by C. J Date'),
		array('name'=>'Thinking Forth'),
		array(
			'name'=>'Little Schemer',
			'done'=>true
		),
		array('name'=>'Domain Driven Design'),
		array('name'=>'Visual Display of Quantitative Information'),

		//unsorted
		array(
			'name'=>'Dreaming in Code',
			'done'=>true),
		array(
			'name'=>'Coders At Work',
			'done'=>true),
		array(
			'name'=>'Clean Code',
			'done'=>true),
		array('name'=>'Introduction to Algorithms, Third Edition'),
		array('name'=>'Michael Abrash\'s Graphics Programming Black Book (Special Edition) (Paperback)'),
		array('name'=>'Zen of Assembly Language: Knowledge (Scott Foresman Assembly Language Programming Series) (Paperback)'),
		array('name'=>'The Annotated Turing'),
		array('name'=>'Growing Object-Oriented Software, Guided by Tests'),
		array('name'=>'Leading Lean Software Development: Results Are not the Point'),
		array('name'=>'Growing Software'),
		array('name'=>'Applied Mathematics for Database Professionals'),
		array('name'=>'The Art of Debugging with GDB, DDD, and Eclipse'),
		array('name'=>'Programming Collective Intelligence'),
		array('name'=>'Delivering happiness'),
		array('name'=>'Refactoring: Improving the Design of Existing Code'),
		array('name'=>'Erlang and OTP in Action'),
		array(
			'name'=>'Steve Jobs',
			'done'=>true),
	);
	return _addBookAttributes($books);
}

function _addBookAttributes($books) {
	$attributes = array('name', 'done', 'note');
	for ($i = 0; $i<count($books); $i++) {
		foreach ($attributes as $attr) {
			$books[$i][$attr] = (isset($books[$i][$attr]) ? $books[$i][$attr] : false);
		}
	}
	return $books;
}
function getBookList($books, $showDone = true) {
	$out = '';
	foreach ($books as $key=>$book) {
		if ($book['done'] == $showDone) {
			//$out .= "<li><strike>{$book['name']}</strike>";
			$out .= "<li>{$book['name']}";
			if (!empty($book['note'])) {
				$out .= "- {$book['note']}";
			}
			$out .= "</li>";
		} else {
			//$out .= "<li><em>{$book['name']}</em></li>";
		}
	}
	return $out;
}

/*function blogs() {
	return array(
		'apple'=>'Apple',
		'code'=>'Code',
		'freelancing'=>'Freelance',
		'fun'=>'Fun',
		'meta code'=>'Meta-Code',
		'web dev'=>'Web Dev'
	);
}*/
?>
