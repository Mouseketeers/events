<?php
class EventsWidget extends Widget {
	static $db = array(
		'WidgetTitle' => 'Varchar',
		'NumberToShow' => 'Int',
		'NoEventsMessage' => 'Varchar',
		'ExcludeOutdated' => 'Boolean'
	);
	static $defaults = array(
		'WidgetTitle' => 'Events',
		'NumberToShow' => 5,
		'NoEMessage' => 'There are currently no events',
		'ExcludeOutdated' => '1'
	);
	static $title = 'Events';
	static $cmsTitle = 'Events';
	static $description = 'This widget displays events. The event module is required to make use of this widget';
	function getCMSFields() {
		return new FieldSet(
			new TextField('WidgetTitle', 'Widget title'),
			new TextField('NumberToShow', 'Number of events to list'),
			new TextField('NoEventsMessage', 'Message to show when there is no events')
		);
	}
	function Events($limit='',$parentID='') {
		$limit = $limit ? $limit : $this->NumberToShow;
		$filter = '';
		if ($this->ExcludeOutdated) $filter = '(FromDate IS NULL OR FromDate >= NOW() - INTERVAL 1 DAY) AND (ToDate IS NULL OR ToDate >= NOW() - INTERVAL 1 DAY)';
		$data = DataObject::get('EventPage', $filter, 'FromDate ASC','',$limit);
 		return $data;
	}
	function Title() {
		return $this->WidgetTitle;
	}
	function NoEventsMessage() {
		return $this->NoEventsMessage;
	}
}