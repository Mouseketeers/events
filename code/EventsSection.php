<?php
class EventsSection extends Page {
	public static $db = array(
		'Pagination' => 'Boolean',
		'NumPages' => 'Int',
		'ExcludeOutdated' => 'Boolean',
		'Scope' => 'Enum("section,subsections,site","section")',
		'DateFilter' => 'Enum("upcoming,previous,nofilter","upcoming")'
	);
	static $has_one = array();
	static $defaults = array(
		'SortOrder' => 'FromDate DESC',
		'ExcludeOutdated' => '1'
	);
 	static $default_child = 'EventPage';
 	static $icon  = 'events/images/eventssection';
  	static $num_pages_options = array(
		0 => 'All',
		2 => '2',
		3 => '3',
		4 => '4',
		5 => '5',
		6 => '6',
		7 => '7',
		8 => '8',
		9 => '9',
		10 => '10',
		15 => '15',
		20 => '20',
		50 => '50',
		100 => '100'
	);
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Content.Settings', 
			array(
				new LiteralField('SectionSettingHeader', '<br /><h3>'._t('Section.SETTINGSHEADER', 'Section Settings').'</h3>'),
				new DropdownField('NumPages','Number of events to list',self::$num_pages_options),
				new OptionsetField('Scope','Scope',
					$source = array(
						'section' => 'Show events in this section',
						'subsections' => 'Show events in this section and all of its subsections',
						'site' => 'Show all events from the entire site'
					)
				),
				new OptionsetField('DateFilter','Date filter',
					$source = array(
						'upcoming' => 'Show upcoming events only',
						'previous' => 'Show previous events only (use this for event archives)',
						'nofilter' => 'Show both upcoming and previous events',
					)
				)
			)
		);
		return $fields;
	}

}
class EventsSection_Controller extends Page_Controller {
	public function ContentList() {
		$scope_filter = '';
		$date_filter = '';
		$limit = '';
		if($this->NumPages) {
			if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
			$limit_start = (int)$_GET['start'];
			$limit = $limit_start.','.$this->NumPages;
		}
		switch($this->Scope) {
			case 'subsections':
				$decendent_ids = $this->getDescendantIDList();
				$scope_filter = '"EventPage"."ID" IN ('.implode(',',$decendent_ids).') ';
				break;

			case 'section':
				$scope_filter = 'ParentID = '. $this->ID;
				break;
		}
		switch($this->DateFilter) {
			case 'upcoming':
				$date_filter = '(FromDate IS NULL OR FromDate >= NOW() - INTERVAL 1 DAY) AND (ToDate IS NULL OR ToDate >= NOW() - INTERVAL 1 DAY)';
				break;

			case 'previous':
				$date_filter = '(FromDate < NOW() - INTERVAL 1 DAY) AND (ToDate IS NULL OR ToDate < NOW() - INTERVAL 1 DAY)';
				break;
		}
		$filter = ($scope_filter) ? $scope_filter.' AND '.$date_filter : $date_filter;

		$data = DataObject::get('EventPage', $filter, 'FromDate DESC','',$limit);
		return $data;
	}
}