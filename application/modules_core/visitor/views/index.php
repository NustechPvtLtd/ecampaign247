<?php if ( !isset( $_GET['id'] ) ) {?><h5>Click on row to get detailed View</h5>
    <table id="visitor-dataTable" class="table table-striped table-bordered  no-wrap" cellspacing="0" width="100%">
        
        <thead>
            <tr>
                <th></th>
                <th><?php echo 'Page Url';?></th>
                <th><?php echo 'Total Hit';?></th>
                <th><?php echo 'Unique Hit';?></th>
            </tr>
        </thead>
        <?php if(!empty($visitors)){?>

            <tbody>
                <?php foreach ($visitors as $visitor):?>
                    <tr id="<?php echo htmlspecialchars($visitor['id'],ENT_QUOTES,'UTF-8');?>">
                        <td></td>
                        <td><?php echo anchor($visitor['page_url'],htmlspecialchars($visitor['page_url'],ENT_QUOTES,'UTF-8'),array('target'=>'_blank'));?></td>
                        <td><?php echo htmlspecialchars($visitor['total_hit'],ENT_QUOTES,'UTF-8');?></td>
                        <td><?php echo htmlspecialchars($visitor['unique_hit'],ENT_QUOTES,'UTF-8');?></td>
                    </tr>
                <?php endforeach;?>
            <tbody>

        <?php }?>
        <tfoot>
            <tr>
                <th></th>
                <th><?php echo 'Page Url';?></th>
                <th><?php echo 'Total Hit';?></th>
                <th><?php echo 'Unique Hit';?></th>
            </tr>
        </tfoot>    
    </table>
    <script>
        $(document).ready( function () {
            var t = $('#visitor-dataTable').DataTable( {
                ordering: true,
                "pageLength": 10,
                responsive: true,
                "columnDefs": [ {
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }
                ],
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        } );

                    // Total over this page
                    pageTotal = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 2 ).footer() ).html(
                        'Total Hits: '+pageTotal +' ( '+ total +' total)'
                    );
                }
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            t.$('tr').click( function () {
              var data = $( this ).attr('id');
              var url = '<?= site_url('visitor?id=')?>'+data;
              console.log(url);
              window.location.assign(url);
            } );

        } );
    </script>
<?php } else {?>
    <style>
        #map_wrapper {
            height: 400px;
            margin-top: 10px;
        }

        #map_canvas {
            width: 100%;
            height: 100%;
        }
        .gmnoprint div img, .gm-style > div:nth-child(1) > div:nth-child(3) > div:nth-child(2) > div:nth-child(1) > div:nth-child(3) > img{max-width:none !important}
        .info_content table tr td {padding:0px !important;}
        .info_content items td{height: 20px !important;}
        .info_content p {
            margin: 0;
        }
        .info_content td {
            border: 1px solid rgba(178, 231, 212, 0.74);
        }
        .info_content tr {
            /*border-bottom: 1px solid #e9e9e9;*/
        }
    </style>
    <a href="<?= site_url('visitor'); ?>">Back</a>
    <table id="visitor-details-dataTable" class="table table-striped table-bordered  no-wrap" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th></th>
                <th><?php echo 'Visitor\'s IP';?></th>
                <th><?php echo 'City';?></th>
                <th><?php echo 'Region';?></th>
                <th><?php echo 'Country';?></th>
                <th><?php echo 'Hitcount';?></th>
                <th><?php echo 'Last visited at';?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($visitors as $visitor):?>
                <tr>
                    <td></td>
                    <td><?php echo htmlspecialchars(long2ip( $visitor['ip'] ),ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($visitor['city'],ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($visitor['region'],ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($visitor['country'],ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($visitor['hitcount'],ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars(date("M jS, Y - h:i:s",strtotime($visitor['timestamp'])),ENT_QUOTES,'UTF-8');?></td>
                </tr>
            <?php endforeach;?>
        </tbody>

        <tfoot>
            <tr>
                <th></th>
                <th><?php echo 'Visitor\'s IP';?></th>
                <th><?php echo 'City';?></th>
                <th><?php echo 'Region';?></th>
                <th><?php echo 'Country';?></th>
                <th><?php echo 'Hitcount';?></th>
                <th><?php echo 'Last visited at';?></th>
            </tr>
        </tfoot>
    </table>
    <div id="map_wrapper">
        <div id="map_canvas" class="mapping"></div>
    </div>
    <?php
    foreach ($visitors as $key => $visitor) {
        foreach ($visitor as $key2 => $value) {
           if($key2 == 'ip'){
               $visitors[$key][$key2] = long2ip($value);
           } 
        }
    }
    ?>
    <script>
        	jQuery(function($) {
				// Asynchronously Load the map API 
				var script = document.createElement('script');
				script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
				document.body.appendChild(script);
			});

			function initialize() {
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					mapTypeId: 'roadmap'
				};

				// Display a map on the page
				map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
				map.setTilt(45);

				// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow();

                        var data = <?php echo json_encode($visitors);?>;

						$.each(eval(data), function() {
							//Plot the location as a marker
                            console.log('lat='+this.lat+'lang='+this.lng+'ip='+this.ip);
							var pos = new google.maps.LatLng(this.lat, this.lng);
							bounds.extend(pos);
							marker = new google.maps.Marker({
								position: pos,
								map: map,
								title: this.ip
							});
							var html = '<div class="info_content">' +
									'<h3>' + this.ip + '</h3>' +
									'<table><tr><td><b>ISP:</b></td><td><p>' + this.isp + '</p></td></tr><tr><td><b>City:</b></td><td><p>' + this.city + '</p></td></tr><tr><td><b>Region:</b></td><td><p>' + this.region + '</p></td></tr><tr><td><b>Country:</b></td><td><p>' + this.country + '</p></td></tr></table>' +
									'</div>'
							google.maps.event.addListener(marker, 'click', (function(marker) {
								return function() {
									infoWindow.setContent(html);
									infoWindow.open(map, marker);
								}
								$('.info_content items th, td').css('height', '20px !important');
							})(marker));
							map.fitBounds(bounds);
						});

				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
					this.setZoom(4);
					google.maps.event.removeListener(boundsListener);
				});
			}
          $(document).ready( function () {
            var t = $('#visitor-details-dataTable').DataTable( {
                ordering: true,
                "pageLength": 10,
                responsive: true,
                "columnDefs": [ {
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }
                ],
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        } );
    </script>
<?php }?>
