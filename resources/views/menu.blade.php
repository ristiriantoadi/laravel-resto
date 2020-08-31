@extends('layouts.app');

<style>
  .menu-container{
    display: flex;
    flex-wrap: wrap;
  }
  .menu-item{
    margin: 20px 10px;
    width:200px;
  }
</style>

@section('content')
<div class="row">
    <div class="col-md-8">
      <div class="card menu-area">
        <div class="card-body">
          <h2 class="card-title">Menu</h2>
          <div id="alert-pesanan-diantarkan" class="alert alert-success" style="display: none" role="alert">
            Pesanan Anda akan segera diantarkan
          </div>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a id="tab-makanan" class="nav-link @if ($jenis === "makanan")
                  active @endif" href="#">Makanan</a>
            </li>
            <li class="nav-item">
              <a id="tab-minuman" class="nav-link @if ($jenis === "minuman")
              active @endif" href="#">Minuman</a>
            </li>
            </li>
          </ul>
          <div class="menu-container" id="menu">
            {{-- @foreach($menus as $menu)
              <div class="card menu-item">
                <div class="card-body">
                  <h3 class="card-title">{{$menu->nama}}</h3>
                  <h5 class="card-title">Rp. {{$menu->harga}}</h5>
                  <button type="button" class="btn btn-info">Beli</button>
                </div>
              </div>
            @endforeach --}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bill-area">
        <div class="card-body">
          <h2 class="card-title">Tagihan</h2>
          <table class="table" id="bill-table">
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">Porsi</th>
                <th scope="col">Harga</th>
              </tr>
          </table>
          <h3 class="card-title" id="total-bayar">Total: Rp. 0</h3>
          <button type="button" id="button-pesan" class="btn btn-success">Pesan</button>
        </div>
      </div>
    </div>
  </div>    
@endsection
<script>
  // console.log(billTable);
  var bills=[];
  var makanan = <?php echo json_encode($makanan); ?>;
  var minuman = <?php echo json_encode($minuman); ?>;
  console.log(makanan);
  console.log(minuman);

  function renderBill(bills){
    var billTable = document.getElementById("bill-table");
    billTable.innerHTML="<tr><th scope='col'>Nama</th><th scope='col'>Porsi</th><th scope='col'>Harga</th></tr>";
    var totalBayar=0
    document.getElementById("total-bayar").innerHTML="Total: Rp. "+totalBayar;
    bills.forEach((bill)=>{
      
      var tdNama = document.createElement('td');
      tdNama.innerHTML=bill.nama;
      var tdPorsi = document.createElement('td');
      tdPorsi.innerHTML=bill.porsi;
      var tdHarga = document.createElement('td');
      tdHarga.innerHTML=bill.harga;
      totalBayar+= bill.harga;

      var tr = document.createElement("tr");
      tr.appendChild(tdNama);
      tr.appendChild(tdPorsi);
      tr.appendChild(tdHarga);
      billTable.appendChild(tr);

      document.getElementById("total-bayar").innerHTML="Total: Rp. "+totalBayar;
    });
  }

  // document.body.onload=()=>{
  //   var bills = [{'nama':"bakso","porsi":2,"harga":10000},
  //             {'nama':"nasi goreng","porsi":4,"harga":20000}]
  //   renderBill(bills);
  // }
  
  function renderMenu(subMenu){
    var menu = document.getElementById("menu");
    menu.innerHTML = "";

    subMenu.forEach((item)=>{
      var menuItem = document.createElement("div");
      menuItem.classList.add("card");
      menuItem.classList.add("menu-item");
      menu.appendChild(menuItem)

      var cardBody = document.createElement("div");
      cardBody.classList.add("card-body");
      menuItem.appendChild(cardBody);

      var namaMenu = document.createElement("h3");
      namaMenu.classList.add("card-title");
      namaMenu.innerHTML=item.nama;
      cardBody.appendChild(namaMenu);
      var hargaMenu = document.createElement("h5");
      hargaMenu.classList.add("card-title");
      // item.harga = item.harga;
      hargaMenu.innerHTML=item.harga;
      if(item.diskon == true){
        hargaMenu.innerHTML += " (diskon 10%)";
      }
      cardBody.appendChild(hargaMenu);

      var buttonBeli = document.createElement("button");
      buttonBeli.innerHTML="Beli";
      buttonBeli.classList.add("btn");
      buttonBeli.classList.add("btn-info");
      buttonBeli.id = item.id;
      console.log("halo");
      buttonBeli.onclick=()=>{
          var item = makanan.find((item)=>{
            console.log("b");
            if(item.id == buttonBeli.id){
              return item;
            }  
          });
          if (item == undefined){
            item = minuman.find((item)=>{
              console.log("undefined");
              if(item.id == buttonBeli.id){
                return item;
              }  
            });
          }
          
          bills.push({"id":item.id,"nama":item.nama,"porsi":1,"harga":item.harga})
          // console.log(bills);
          renderBill(bills);
      }


      cardBody.appendChild(buttonBeli);
    })

  }


  document.body.onload=()=>{
    var tabMakanan = document.getElementById('tab-makanan');
    var tabMinuman = document.getElementById('tab-minuman');

    tabMakanan.onclick=()=>{
      renderMenu(makanan);
      tabMakanan.classList.add("active");
      tabMinuman.classList.remove("active");
    }
    tabMinuman.onclick=()=>{
      renderMenu(minuman);
      tabMinuman.classList.add("active");
      tabMakanan.classList.remove("active");
    }
    renderMenu(makanan);

    var buttonPesan = document.getElementById("button-pesan");
    var token=$('meta[name="csrf-token"]').attr('content');

    buttonPesan.onclick = ()=>{
      var pesanan = bills.map(x=>{
      return x.id;
    });
    console.log(pesanan);
      if(confirm("Anda yakin dengan pesanan Anda?")){  
        fetch("/menu/pesan", {
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
          },
          method: 'post',
          credentials: "same-origin",
          body: JSON.stringify({
            pesanan: pesanan
          })
        })
        .then((data)=>{
          // console.log(data.status);
          if(data.status == "200"){
            bills=[]
            renderBill(bills);
            alertPesanan = document.getElementById("alert-pesanan-diantarkan");
            alertPesanan.style.display="block";
          }
        })
        // .then((data) => {
        //   form.reset();
        //   window.location.href = redirect;
        // })
        .catch(function(error) {
          console.log(error);
        });
      }
    }
  }

</script>