// $koneksi = variable yang menyimpan koneksi ke database;
include'koneksi.php';

// $id = variabel penampung nilai dari parameter 'id' di URL;
$id = ''; 
if( isset( $_GET['id'])) {
    $id = $_GET['id']; 
} 

// $msg = variabel penampung pesan yang akan dikirim ke client;
$msg = '';

// $code = variabel penampung kode status yang akan dikirim ke client;
$code = '';

// Jika variabel $id tidak kosong, maka lakukan query SELECT ke tabel 'users' dengan WHERE id = $id;
if (!empty($id))
{
    //Single data with param id
    $query = mysqli_query($koneksi,"select * from users where id='$id'");

// Jika jumlah data yang dikembalikan lebih dari 0, maka statusnya 200 dan pesannya "Succesfull";
    if (mysqli_num_rows($query) > 0) {
        $code = 200;
        $msg = "Succesfull";

// Jika jumlah data yang dikembalikan tidak lebih dari 0, maka statusnya 204 dan pesannya "No data found";
    }else{
        $code = 204;
        $msg = "No data found";	
    }
}else
{
    // Jika variabel $id kosong, maka lakukan query SELECT semua data dari tabel 'users';
    //All Data
    $query = mysqli_query($koneksi,"select * from users");

// Jika jumlah data yang dikembalikan lebih dari 0, maka statusnya 200 dan pesannya "Succesfull";
    if (mysqli_num_rows($query) > 0) {
        $code = 200;
        $msg = "Succesfull";

// Jika jumlah data yang dikembalikan tidak lebih dari 0, maka statusnya 204 dan pesannya "No data found";
    }else{
        $code = 204;
        $msg = "No data found";	
    }
};

// Buat array response yang berformat seperti:
// {
//   "success": true/false,
//   "data": [
//     {
//       "id": "",
//       "username": "",
//       "password": "",
//       "level": "",
//       "fullname": ""
//     }
//   ],
//   "message": "",
//   "code": ""
// }
$response = array();
$response["success"] = true;
$response["data"] = array();
$response["message"] = $msg;
$response["code"] = $code;

// Perulangan untuk mengambil data dari query SELECT dan masukkan ke dalam array response;
while ($row = mysqli_fetch_assoc($query)) {
    // kerangka format penampilan data json
    $data['id'] = $row["id"];
    $data['username'] = $row["username"];
    $data['password'] = $row["password"];
    $data['level'] = $row["level"];
    $data['fullname'] = $row["fullname"];
    array_push($response["data"], $data);
}

// Untuk mengubah array response menjadi format JSON dan mengirimkan ke client;
echo json_encode($response);