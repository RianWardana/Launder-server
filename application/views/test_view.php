<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Launder</title>
	</head>

	<body>
		<!-- <button id="send_button">Hello</button>
		<input type="text" id="input" readonly value="Klik tombol samping"> -->


		<script src="assets/jquery.min.js"></script>
		<script>
			var ini = this;
			var katalog = [];
			var jenis = [];
			var warna = [];

			$.ajax({
				url: 'http://192.168.0.3/launder/api',
				success: function(respons){
					var data = JSON.parse(respons);

					// ISI KATALOG //
					katalog = [];
					$.each(data.katalog, function(i, katalog) {
						ini.katalog.push({
							rowid: katalog.rowid,
							nama: katalog.nama,
							jenis: katalog.jenis,
							warna: katalog.warna,
							keterangan: katalog.keterangan,
							dicuci: katalog.dicuci
						});
					});

					// ISI JENIS //
					jenis = [];
					$.each(data.jenis, function(i, jenis) {
						ini.jenis.push({
							rowid: jenis.rowid,
							nama: jenis.nama,
							jenis: jenis.jenis,
							jumlah: jenis.jumlah
						});
					});

					// ISI WARNA //
					warna = [];
					$.each(data.warna, function(i, warna) {
						ini.warna.push({
							rowid: warna.rowid,
							warna: warna.warna,
							hex: warna.hex
						});
					});
						
					console.table(ini.katalog);
					console.table(ini.jenis);
					console.table(ini.warna);
				}
			});


			/*var jenis = [
				{ nama: 'K', jenis: 'Kaos' },
				{ nama: 'J', jenis: 'Jaket' }
			];

			var warna = [
				{ warna: 'Merah', hex: '#123123' },
				{ warna: 'Putih', hex: '#FFF' }
			];

			var katalog = [
				{ nama: 'K01', jenis: 'Kaos' },
				{ nama: 'J01', jenis: 'Jaket' }
			];

			var data = { 
				katalog: katalog,
				jenis: jenis,
				warna: warna
			};

			$('#send_button').on('click', function(){
				$.ajax({
					url: '<?php echo base_url('api/post');?>',
					type: 'POST',
					data: data,
					success: function(string){
						$('#input').val('Berhasil');
					}
				});
				console.log(data)
			});*/
		</script>
	</body>
</html>