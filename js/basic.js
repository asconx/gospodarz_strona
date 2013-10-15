function countDays() {
	var start = $('#dateStart').val(),
		end = $('#dateEnd').val(), totalDays;
	
	start = start.split('-');
	end = end.split('-');
	
	dateStart = new Date();
	dateEnd = new Date();
	
	if (start && start.length>1 && end && end.length>1) {
		if(start[0][0] == '0') start[0] = start[0][1];
		if(start[1][0] == '0') start[1] = start[1][1];
		if(end[0][0] == '0') end[0] = end[0][1];
		if(end[1][0] == '0') end[1] = end[1][1];
		dateStart = new Date(start[2], start[1], start[0]);
		dateEnd   = new Date(end[2], end[1], end[0]);
	}
	
	totalDays = ( (dateEnd.getTime() - dateStart.getTime()) / (1000*60*60*24) );
	
	$('#daysTotal').val(totalDays);
	
	return totalDays;
	
}