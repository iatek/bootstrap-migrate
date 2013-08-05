<?
define('LARGE',1);
define('SMALL',2);
define('TINY',3);

class bootstrapmigration2to3
{
  var $errors;
	var $warnings;
	var $doc;
	
	function __construct($template)
	{
		$this->errors = array();
		$this->warnings = array();
		$this->doc = new DOMDocument();
		$this->doc->loadHTML($template);
	}
	
	
	function migrate($grid = LARGE,$responsiveimages=true)
	{
		$this->migrategrid($grid);
		
		if($responsiveimages)$this->responsiveimages();
		
		$this->replaceclasses();
		$this->migratenavbar();
		$this->migrateicons();
		
		return array($this->doc->saveHTML(),$this->errors,$this->warnings); 
	}
	
	function responsiveimages()
	{
		$images = $this->doc->getElementsByTagName('img');
		foreach ($images as $image) {
			if($image->hasAttribute('class'))
			{
				$image->setAttribute('class',$image->getAttribute('class').' img-responsive');
			}
			else
			{
				$image->setAttribute('class','img-responsive');
			}		
			
		}
	}	
	
	function migrategrid($grid)
	{
		/* is de default grid used ?*/
		
		$defaultgrid = preg_match('/class="row"|class=\'row\'/ms',$this->doc->saveHTML()); /* TODO find better check */
		if($defaultgrid)
		{
			$this->warnings[] = 'Your template uses Twitter\'s Bootstrap default grid. Twitter\'s Bootstrap 3 uses fluid grid by default. If your template contains nested rows you will have to fix them by hand, see also: <a href="http://bassjobsen.weblogs.fm/migrate-your-templates-from-twitter-bootstrap-2-x-to-twitter-bootstrap-3/">Migrate your templates from Twitter Bootstrap 2.x to Twitter Bootstrap 3</a>';
		}	
		
		switch ($grid) {
    case 3:
        $prefix = 'col-';
        break;
    case 2:
        $prefix = 'col-sm-';
        break;
    default:
        $prefix = 'col-lg-';
        break;
		}
		
		$replacements = array();
		
		for($i=1; $i<=12; $i++)
		{
			$replacements['span'.$i] = $prefix.$i;
		}	
		
		$replacements['container-fluid'] = 'container';
		$replacements['row-fluid'] = 'row';
		
		$this->docreplaceclasses($replacements);
		
	}
	
	function replaceclasses()
	{
		$replacements = array();
		
		//$replacements['brand'] = 'navbar-brand';
		//$replacements['navbar nav'] = 'nav navbar-nav';
		$replacements['hero-unit'] = 'jumbotron';
		//$replacements['icon-*'] = 'glyphicon glyphicon-*';
		$replacements['btn'] = 'btn-default'; /* check this */
		$replacements['btn-mini'] = 'btn-small';
		$replacements['visible-phone'] = 'visible-sm';
		$replacements['visible-tablet'] = 'visible-md';
		$replacements['visible-desktop'] = 'visible-lg';
		$replacements['hidden-phone'] = 'hidden-sm';
		$replacements['hidden-tablet'] = 'hidden-md';
		$replacements['hidden-desktop'] = 'hidden-lg';
		$replacements['input-prepend'] = 'input-group';
		$replacements['input-append'] = 'input-group';
		$replacements['add-on'] = 'input-group-addon';
		//$replacements['btn-navbar'] = 'navbar-btn';
		$replacements['thumbnail'] = 'img-thumbnail';
		
		$this->docreplaceclasses($replacements);
	}		
	
	function migratenavbar()
	{
		/* TODO */
		
		$havenavbar = preg_match('/navbar-inner/ms',$this->doc->saveHTML()); /* TODO find better check */
		if($havenavbar)
		{
			$this->warnings[] = 'Navbar are not migrate yet. We will fix this in the next version.';
		}
		
	}	
	
	function migrateicons()
	{
		/* TODO */
		$haveicons = preg_match('/icon-/ms',$this->doc->saveHTML()); /* TODO find better check */
		if($havenavbar)
		{
			$this->warnings[] = 'Glyphicons are not migrate yet. We will fix this in the next version. NOTE: With the launch of Bootstrap 3, icons have been moved to a <a href="http://glyphicons.getbootstrap.com/">separate repository</a>.';
		}
		
		
	}	
	
	function docreplaceclasses($replacements)
	{
		foreach ($replacements as $old=>$new)
		{
			$tags = $this->doc->getElementsByTagName('*');
			foreach ($tags as $tag) {
			if($tag->hasAttribute('class'))
			{
				$classes = $tag->getAttribute('class');
				if(preg_match('/('.$old.'|^'.$old.' | '.$old.'$| '.$old.' )/i',$classes,$matches))
				{
					$tag->setAttribute('class',trim(str_replace($matches[1],' '.$new,$classes)));
			    }
			}	
			
			}
		}
	}
	
}

