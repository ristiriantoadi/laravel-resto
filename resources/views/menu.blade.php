@extends('layouts.header');

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
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link @if ($jenis === "makanan")
                  active @endif" href="/menu/makanan">Makanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if ($jenis === "minuman")
              active @endif" href="/menu/minuman">Minuman</a>
            </li>
            </li>
          </ul>
          <div class="menu-container">
            @foreach($menus as $menu)
              <div class="card menu-item">
                <div class="card-body">
                  <h3 class="card-title">{{$menu->nama}}</h3>
                  <h5 class="card-title">Rp. {{$menu->harga}}</h5>
                  <button type="button" class="btn btn-info">Beli</button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bill-area">
        <div class="card-body">
          <h2 class="card-title">Pembayaran</h2>
          <table class="table" id="bill-table">
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">Porsi</th>
                <th scope="col">Harga</th>
              </tr>
          </table>
          <h3 class="card-title">Total: 40000</h3>
        </div>
      </div>
    </div>
  </div>    
@endsection
<script>
  // console.log(billTable);

  function renderBill(bills){
    var billTable = document.getElementById("bill-table");
    bills.forEach((bill)=>{
      
      var tdNama = document.createElement('td');
      tdNama.innerHTML=bill.nama;
      var tdPorsi = document.createElement('td');
      tdPorsi.innerHTML=bill.porsi;
      var tdHarga = document.createElement('td');
      tdHarga.innerHTML=bill.harga;

      var tr = document.createElement("tr");
      tr.appendChild(tdNama);
      tr.appendChild(tdPorsi);
      tr.appendChild(tdHarga);
      billTable.appendChild(tr);
    });
  }

  document.body.onload=()=>{
    var bills = [{'nama':"bakso","porsi":2,"harga":10000},
              {'nama':"nasi goreng","porsi":4,"harga":20000}]
    renderBill(bills);
  }

</script>