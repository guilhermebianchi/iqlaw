	<!-- jQuery 2.1.4 -->
	<script src="assets/vendors/select2/select2.full.min.js"></script> <!-- InputMask -->
	<script src="assets/vendors/input-mask/jquery.inputmask.js"></script>
	<script src="assets/vendors/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="assets/vendors/input-mask/jquery.inputmask.extensions.js"></script><!-- date-range-picker -->
	<script src="assets/vendors/moment-js/moment.min.js"></script>
	<script src="assets/vendors/daterangepicker/daterangepicker.js"></script>
	<script src="assets/vendors/datepicker/bootstrap-datepicker.js"></script>
	<script src="assets/vendors/colorpicker/bootstrap-colorpicker.min.js"></script> <!-- bootstrap time picker -->
	<script src="assets/vendors/timepicker/bootstrap-timepicker.min.js"></script> <!-- SlimScroll 1.3.0 -->
	<script src="assets/vendors/slimScroll/jquery.slimscroll.min.js"></script> <!-- iCheck 1.0.1 -->
	<script src="assets/vendors/iCheck/icheck.min.js"></script> <!-- FastClick -->
	<script src="assets/vendors/datatables/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
	<script src="assets/vendors/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="assets/vendors/iconpicker/fontawesome-iconpicker.min.js"></script>
	
	<script src="assets/vendors/mylibs/lib.js"></script>
	
	<script src="assets/vendors/fastclick/fastclick.min.js"></script> <!-- AdminLTE App -->
	<script src="assets/vendors/dist/js/app.min.js"></script> <!-- AdminLTE for demo purposes -->
	<script src="assets/vendors/dist/js/demo.js"></script> <!-- Page script -->
	<script>
	$(function() {

		$.expr[":"].contains = $.expr.createPseudo(function(arg) {
		    return function( elem ) {
		        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		    };
		});
		$('.sidebar-form input').on("keypress", function(e) {
			$('.sidebar-menu li').hide();
			$('.sidebar-menu .header').show();
			term = $(this).val();
			$('.sidebar-menu li:contains("'+term+'")').show();
		}).on("blur", function(e) {
			if ($(this).val() == "") {
				$('.sidebar-menu li').show();
			}
		});
		$('.sidebar-form').on("submit", function(e) {
			e.preventDefault();
		});

		
		$('.font-awesome-icon').iconpicker();
		
		$(".wysiwyg").wysihtml5();
		
		//Initialize Select2 Elements
		$(".select2").select2();
		//Datemask dd/mm/yyyy
		
		$("[type=date]").inputmask("dd/mm/yyyy").datepicker({
			format: 'dd/mm/yyyy'
		});
		
		//Money Euro
		$("[data-mask]").inputmask();
		
		//Date range picker
		$('#reservation').daterangepicker();
		//Date range picker with time picker
		$('#reservationtime').daterangepicker({
			timePicker: true,
			timePickerIncrement: 30,
			format: 'MM/DD/YYYY h:mm A'
		});
		//Date range as a button
		$('#daterange-btn').daterangepicker({
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate: moment()
		}, function(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		});
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		//Red color scheme for iCheck
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red',
			radioClass: 'iradio_minimal-red'
		});
		//Flat red color scheme for iCheck
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});
		//Colorpicker
		$(".my-colorpicker1").colorpicker();
		//color picker with addon
		$(".my-colorpicker2").colorpicker();
		//Timepicker
		$(".timepicker").timepicker({
			showInputs: false
		});

        table = $(".table").DataTable({
	        "stateSave": true,
        	"processing": true,
	        "scrollX": false,
    		"paging": true,
    		"lengthChange": false,
    		"searching": true,
    		"ordering": true,
    		"info": true,
    		"autoWidth": true,

			'aoColumnDefs': [{
				'bSortable': false,
				'aTargets': [-1] /* 1st one, start by the right */
			}]
    	});
	});
	</script>