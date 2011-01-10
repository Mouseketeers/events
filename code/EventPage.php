<?php
class EventPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date',
		'Location' => 'Text',
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
		$fields->addFieldToTab('Root.Content.Main',new TextField('Location','Location'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('ExternalLink','Link'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new TextField('LinkText','Link Text'),'Content');
		return $fields;
	}
}
class EventPage_Controller extends Page_Controller {
	public function OtherEvents($limit='') {
		$filter = '`EventPage`.`ID` <> '.$this->ID
			.' AND ParentID = '.$this->ParentID;
			//.' AND (ToDate IS NULL OR ToDate >= NOW()) AND (FromDate IS NULL OR FromDate <= NOW())';
		$sortorder = 'FromDate DESC';
		return DataObject::get('EventPage', $filter, $sortorder, '', $limit);
	}
}
?>