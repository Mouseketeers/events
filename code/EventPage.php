<?php
class EventPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date',
		'Location' => 'Text',
		'ExternalLink' => 'Varchar',
		'LinkText' => 'Varchar',
		'IsWebEvent' => 'Boolean',
		'IsPermanentEvent' => 'Boolean',
		'Subtitle' => 'Text'
	);
	static $has_one = array (
		'EventImage' => 'Image'
	);
	static $default_parent = "EventsSection";
	static $allowed_children = "none";
	static $can_be_root = false;
	static $default_sort = "FromDate ASC";
	static $defaults = array( 
		'ShowInMenus' => false
	);
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.Main',new TextField('Subtitle','Subtitle'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CalendarDateField('FromDate','From'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CalendarDateField('ToDate','To'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('Location','Location'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('ExternalLink','Link'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('LinkText','Link Text'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CheckboxField('IsWebEvent','This is a web exhibition'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CheckboxField('IsPermanentEvent','This is a permanent exhibition'),'Content');
		$fields->addFieldToTab('Root.Content.Main', new ImageField('EventImage', 'Event Image','Content'));
		return $fields;
	}
}
class EventPage_Controller extends Page_Controller {
	function OtherEvents($num='') {
		return DataObject::get('EventPage', 'EventPage_Live.ID <> '.$this->ID.' AND (ToDate IS NULL OR ToDate >= NOW()) AND (FromDate IS NULL OR FromDate < NOW())', 'FromDate DESC', '', $num);		
	}

}
?>