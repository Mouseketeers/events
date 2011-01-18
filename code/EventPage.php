<?php
class EventPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date',
		'Venue' => 'Text',
		'City' => 'Varchar',
		'Country' => 'Varchar',

		'ExternalLink' => 'Varchar',
		'LinkText' => 'Varchar'
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
		$fields->addFieldToTab('Root.Content.Main',new CalendarDateField('FromDate','From'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CalendarDateField('ToDate','To'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('Venue','Venue'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('City','City'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('Country','Country'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('ExternalLink','Link'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('LinkText','Link Text'),'Content');
		return $fields;
	}
	function NiceFromToDate() {
		$from_date = new Date();
		$to_date = new Date();
		$from_date->setValue($this->FromDate);
		$to_date->setValue($this->ToDate);
		
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