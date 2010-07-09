<?php
class EventsSection extends Section {
	static $db = array();
	static $has_one = array();
	//static $allowed_children = array('EventPage');
 	static $default_child = 'EventPage';
	
	public function Events($num='', $parent='', $sort='FromDate DESC', $is_web_event=0, $is_permament_event=0) {
		$where = '(ToDate IS NULL OR ToDate >= NOW()) AND (FromDate IS NULL OR FromDate <= NOW()) AND IsWebEvent = '.$is_web_event .' AND IsPermanentEvent = '.$is_permament_event;
		if ($parent) $where .= ' AND ParentID = '.$this->ID;
		return DataObject::get('EventPage', $where, $sort, '', $num);
		//return DataObject::get('EventPage', 'ParentID = '.$this->ID.' AND (FromDate > NOW())', 'FromDate DESC', '', $num);
	}
	public function UpcomingEvents($num='', $parent='', $sort='FromDate DESC', $is_web_event=0) {
		$where = 'FromDate > NOW() AND IsWebEvent = '.$is_web_event;
		if ($parent) $where .= ' AND ParentID = '.$this->ID;
		return DataObject::get('EventPage', $where, $sort, '', $num);
	}
	function EventFilters($num='', $parent='', $sort='FromDate DESC') {
		//$filters =  array( array( 'MenuTitle' => 'test'), array( 'MenuTitle' => 'test') );
		$filters = new DataObjectSet (
			array(
					array(
						  'MenuTitle' => 'Aktuelle udstillinger',
						  'LinkingMode' => $this->FilterLinkMode('aktuelle'),
						  'Link' => $this->Link().'aktuelle'
					),
					array(
						  'MenuTitle' => 'Kommende udstillinger',
						  'LinkingMode' => $this->FilterLinkMode('kommende'),
						  'Link' => $this->Link().'kommende'
					),
					array(
						  'MenuTitle' => 'Webudstillinger',
						  'LinkingMode' => $this->FilterLinkMode('web'),
						  'Link' => $this->Link().'web'
					),
					array(
						  'MenuTitle' => 'Dragtsamlinger',
						  'LinkingMode' => $this->FilterLinkMode('samlinger'),
						  'Link' => $this->Link().'samlinger'
					)
			)
		);
		return $filters;
	}
	public function FilterLinkMode($filter) {
		return ($filter == Director::urlParam('Action')) ? 'current' : 'link';	
	}

}
class EventsSection_Controller extends Section_Controller {
	function init(){
		parent::init();
	}
	public function Events($num='') {
		return EventsSection::Events($num,$this->ID);
	}
	public function UpcomingEvents($num='') {
		return EventsSection::UpcomingEvents($num,$this->ID);
	}
	public function WebEvents($num='') {
		return EventsSection::Events($num,$this->ID,'FromDate DESC',1);
	}
	public function PermanentEvents($num='') {
		return EventsSection::Events($num,$this->ID,'FromDate DESC',0,1);
	}
	public function CurrentFilter() {
		return Director::urlParam('Action');
	}
}
?>