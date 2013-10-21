<?php
class EventPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date',
		'Time' => 'Varchar',
		'Venue' => 'Text',
		'City' => 'Varchar',
		'Country' => 'Varchar',
		'ExternalLink' => 'Varchar',
		'LinkText' => 'Varchar',
		'Abstract' => 'Text'
	);
	static $has_one = array (
	);
	static $default_parent = "EventsSection";
	static $allowed_children = "none";
	static $can_be_root = false;
	static $default_sort = "FromDate ASC";
	static $defaults = array( 
		'ShowInMenus' => false
	);
	static $icon  = 'events/images/eventpage';
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$from_date_field = new DateField('FromDate', _t('NewsPage.FROM','From date'));
		$from_date_field->setConfig('showcalendar',true);
		
		$to_date_field = new DateField('ToDate', _t('NewsPage.TO','To date'));
		$to_date_field->setConfig('showcalendar',true);
		
		$fields->addFieldToTab('Root.Content.Main',$from_date_field,'Content');
		$fields->addFieldToTab('Root.Content.Main',$to_date_field,'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('Time','Time (e.g. 16.00 - 18.00)'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('Venue','Venue'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('City','City'),'Content');
		//$fields->addFieldToTab('Root.Content.Main',new TextField('Country','Country'),'Content');
		//$fields->addFieldToTab('Root.Content.Main',new TextField('ExternalLink','Link to external site (e.g. http://www.example.com)'),'Content');
		//$fields->addFieldToTab('Root.Content.Main',new TextField('LinkText','Link Text'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextAreaField('Abstract','Abstract'),'Content');
		return $fields;
	}
	/*
	 * Takes two dates and makes stuff like "17. - 18. January 2010"
	 */
	function NiceFromToDate() {
		if (!$this->ToDate && $this->FromDate) return '';
		
		$from_date = new Date();
		$to_date = new Date();
		$from_date->setValue($this->FromDate);
		$to_date->setValue($this->ToDate);
				
		if (!$this->ToDate && $this->FromDate) return $from_date->FormatI18N('%e. %B %Y');

		$from_month = $from_date->FormatI18N('%B');
		$to_month = $to_date->FormatI18N('%B');
		
		$from_year = $from_date->Format('Y');
		$to_year = $from_date->Format('Y');
		
		if($from_month == $to_month) {
			$long_from_to_date = $from_date->Format('j. - ').$to_date->Format('j. ').$to_month.' '.$to_year;
		}
		elseif($from_year == $to_year) {
			$long_from_to_date = $from_date->Format('j. ').$from_month.' - '.$to_date->Format('j. ').$to_month.' '.$to_year;
		}
		else {
			$long_from_to_date = $from_date->FormatI18N('%e. %B %Y') . ' - ' . $to_date->FormatI18N('%e. %B %Y');
		}
		return $long_from_to_date;
		//$this->FromDate->setConfig('dateformat','dd/MM/y');//.FormatI18N('%e. %B %Y');
	}
}
class EventPage_Controller extends Page_Controller {
	/* shows other events in the current section */
	public function OtherEvents($limit='') {
		//if the event doesn't have EventsSection parent, don't do anything
		if(!$this->parent()->exists() || $this->parent()->ClassName != 'EventsSection') return false;
		
		$filter = '`EventPage`.`ID` <> '.$this->ID.' AND ParentID = '.$this->ParentID;
		if ($this->Parent()->ExcludeOutdated) $filter .= ' AND (ToDate IS NULL OR ToDate >= NOW())';
		$sortorder = 'FromDate DESC';
		return DataObject::get('EventPage', $filter, $sortorder, '', $limit);
	}

}
?>