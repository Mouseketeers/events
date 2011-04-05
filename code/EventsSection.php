<?php
class EventsSection extends Page {
	public static $db = array(
		'Pagination' => 'Boolean',
		'NumPages' => 'Int',
		'ExcludeOutdated' => 'Boolean',
		'NoEventsText' => 'Text'
	);
	static $has_one = array();
	//static $allowed_children = array('EventPage');
	static $defaults = array(
		'SortOrder' => 'FromDate DESC',
		'ExcludeOutdated' => '1'
	);
 	static $default_child = 'EventPage';
 	static $icon  = 'events/images/eventssection';
 	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab(
			'Root.Content.Settings', new LiteralField(
				$name = 'SlideshowSettingsHeader',
	   			$content = '<h3>'._t('EventsSection.SETTINGSHEADER', 'Events Section Settings').'</h3>'
			)
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Settings',
			new NumericField(
				$db_name = 'NumPages',
				$cms_label = _t('EventSection.MAX_PAGES_TO_LIST','Max pages to list (set to 0 to list all pages)')
			),
			$place_before = ''
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Settings',
			new CheckboxField(
				$db_name = 'ExcludeOutdated',
				$cms_label = _t('EventSection.EXCLUDE_OUTDATED','Exclude outdated events from the list')
			),
			$place_before = ''
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Settings',
			new TextAreaField(
				$db_name = 'NoEventsText',
				$cms_label = _t('EventSection.NoEventsText','Text to show when there are no events')
			),
			$place_before = ''
		);
		return $fields;
	}
	
	public function Events($num='', $parent='', $sort='FromDate DESC') {
		$where = '(ToDate IS NULL OR ToDate >= NOW()) AND (FromDate IS NULL OR FromDate <= NOW())';
		if ($parent) $where .= ' AND ParentID = '.$this->ID;
		return DataObject::get('EventPage', $where, $sort, '', $num);
		//return DataObject::get('EventPage', 'ParentID = '.$this->ID.' AND (FromDate > NOW())', 'FromDate DESC', '', $num);
	}
	public function UpcomingEvents($num='', $parent='', $sort='FromDate DESC') {
		$where = 'FromDate > NOW() AND IsWebEvent = '.$is_web_event;
		if ($parent) $where .= ' AND ParentID = '.$this->ID;
		return DataObject::get('EventPage', $where, $sort, '', $num);
	}

}
class EventsSection_Controller extends Page_Controller {
	public function ContentList() {
		$limit = '';
		if($this->NumPages) {
			if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
			$limit_start = (int)$_GET['start'];
			$limit = $limit_start.','.$this->NumPages;
		}
		$filter = 'ParentID = '. $this->ID;
		//if ($this->ExcludeOutdated) $filter .= ' AND (ToDate IS NULL OR ToDate >= NOW()) AND (FromDate IS NULL OR FromDate <= NOW())';
		if ($this->ExcludeOutdated) $filter .= ' AND ToDate IS NULL OR ToDate >= NOW()';
		$data = DataObject::get('EventPage', $filter, 'FromDate DESC','',$limit);
		return $data;
	}
}
?>