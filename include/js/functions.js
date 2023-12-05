function select_county(){
	var county = $("#jimbo").val();
	$.ajax({
		url: '../include/county.php',
		method: 'POST',
		data: 'county=' + county
	}).done(function(data){
		data = JSON.parse(data);
		var bunge = $('#bunge').empty();
		data.forEach(function(data){
			bunge.append('<option>' + data.constituency_name + '</option>')
		})
	})
}

function select_ward(){
	var constituency = $("#bunge").val();
	$.ajax({
		url: '../include/ward.php',
		method: 'POST',
		data: 'constituency=' + constituency
	}).done(function(data){
		data = JSON.parse(data);
		var wards = $('#ward').empty();
		data.forEach(function(data){
			wards.append('<option>' + data.ward + '</option>')
		})
	})
}

function edit_marks(id){
	document.getElementById("uid").value = id;
	var table  = document.getElementById('pager');
	for(var i = 1; i < table.rows.length; i++)
		{
			table.rows[i].onclick = function()
			{
				document.getElementById("openermarks").value = this.cells[4].innerHTML;
				document.getElementById("midtermmarks").value = this.cells[5].innerHTML;
				document.getElementById("endterm").value = this.cells[6].innerHTML;
										
			};
		}
}


function TableFilter() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("pager");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
	td = tr[i].getElementsByTagName("td")[0];
	if (td) {
	  txtValue = td.textContent || td.innerText;
	  if (txtValue.toUpperCase().indexOf(filter) > -1) {
		tr[i].style.display = "";
	  } else {
		tr[i].style.display = "none";
	  }
	}       
  }
}

function printDiv() {
	var divContents = document.getElementById("GFG").innerHTML;
	var a = window.open('', '', 'height=500, width=500', align='center');
	a.document.write('<html>');
	a.document.write('<body> <h1>SALES REPORT<br><hr>');
	a.document.write(divContents);
	a.document.write('</body></html>');
	a.document.close();
	a.print();
}

function DateFilteR(){
  var StartDate, EndDate, table,total, tvar, trvar, tr, check, i;
  StartDate = new Date(document.getElementById("min_date").value);
  EndDate = new Date(document.getElementById("max_date").value);
  table = document.getElementById("pager");
  tr = table.getElementsByTagName("tr");
  total = 0;
  for (let i=1; i < table.rows.length; i++){
	trvar = parseInt(table.rows[i].cells[4].textContent);
	check = table.rows[i].cells[5].textContent;
	check = check.replaceAll("-","/");
	check = new Date(check);
	total = total+trvar;
	if(check<StartDate || check>EndDate){
		trvar = parseInt(table.rows[i].cells[4].textContent);
		tr[i].style.display='none';
		total = total-trvar;
	  }
  }		  
  document.getElementById("tval").innerHTML = tvar-total;
}


function edit_user(){
	var id = event.srcElement.id;
	var table  = document.getElementById('pager');
	for(var i = 1; i < table.rows.length; i++)
		{
			table.rows[i].onclick = function()
			{
				document.getElementById("ufname").value = this.cells[0].innerHTML;
				document.getElementById("uid").value = this.cells[1].innerHTML;
				document.getElementById("uphone").value = this.cells[3].innerHTML;
				document.getElementById("uemail").value = this.cells[4].innerHTML;
			};
		}
}

function NotAllowed(){
	//alert('You are not allowed to perform this function');
	$('#AlertModal').appendTo("body").modal('show');
}

//Calendar
$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "../include/fetch-event.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        }
    });
});

function displayMessage(message) {
	    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}