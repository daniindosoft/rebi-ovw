truncate semua_wilayah;
INSERT INTO semua_wilayah (nama) SELECT CONCAT_WS(', ',wilayah_provinsi.nama, wilayah_kabupaten.nama, wilayah_kecamatan.nama) 
FROM wilayah_kabupaten
INNER JOIN wilayah_kecamatan ON wilayah_kabupaten.id = wilayah_kecamatan.kabupaten_id
INNER JOIN wilayah_provinsi ON wilayah_provinsi.id = wilayah_kabupaten.provinsi_id