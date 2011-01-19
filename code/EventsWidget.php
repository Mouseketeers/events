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
	/*function Events($num='',$parentID=''){
		$num = $num ? $num : $this->NumberToShow;
		$data = DataObject::get('EventPage', 'FromDate IS NULL OR FromDate <= NOW()', 'FromDate DESC', '', $num);
 		return $data;
	}*/
	function Events($limit='',$parentID='') {
		$limit = $limit ? $limit : $this->NumberToShow;
		$filter = '';
		if ($this->ExcludeOutdated) $filter = 'ToDate IS NULL OR ToDate >= NOW()';
		/*$filter = 'FromDate IS NULL OR FromDate <= NOW()';*/
		$data = DataObject::get('EventPage', $filter, 'FromDate ASC','',$limit);
 		return $data;
	}
	function Title() {
		return $this->WidgetTitle ? $this->WidgetTitle : self::$title;
	}
	function NoEventsMessage() {
		return $this->NoEventsMessage;
	}
}

?>