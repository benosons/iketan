$(() => {
  $('.customizer-links').hide()
  getallproduk()
  getharianterjual()
});

function jual(id, harga) {
  getallproduk()
  getharianterjual()
  $.ajax({
    type: "post",
    dataType: "json",
    data : {
      id : id, 
      harga : harga
    },
    url: "/menjualproduk",
    success: function (result) {
    }
  })
  
}

function getallproduk() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "/getallproduk",
    success: function (result) {
      let elem = ''
        console.log('ada');
        result.data.forEach(element => {
          elem += `<div class="col-lg-3 col-sm-6 col-6 d-flex ">
                      <div class="productset flex-fill">
                        <div class="productsetimg">
                            <img src="https://dreamspos.dreamguystech.com/html/template/assets/img/product/product29.jpg" alt="img">
                            <h6>${element.qty}</h6>
                            <div class="check-product">
                              <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="productsetcontent">
                            <h4>${element.nama}</h4>
                            <h6>Rp. ${element.harga}</h6>
                            <button onclick="jual('${element.id}', '${element.harga}')" class="btn btn-adds" data-bs-toggle="modal" data-bs-target="#create"><i class="fa fa-plus me-2"></i>JUAL</button>
                        </div>
                      </div>
                  </div>`
        });
        
        $('#list_produk').html(elem)
    }
  })

}

function getharianterjual() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "/getharianterjual",
    success: function (result) {
      let elem = ''
      let totall = 0
      $('#total-produk').text(result.data.length)
        result.data.forEach(element => {
          elem += `<ul class="product-lists">
                      <li>
                        <div class="productimg">
                            <div class="productimgs">
                              <img src="https://dreamspos.dreamguystech.com/html/template/assets/img/product/product30.jpg" alt="img">
                            </div>
                            <div class="productcontet">
                              <h4>${element.nama}
                                  <a href="javascript:void(0);" class="ms-2" data-bs-toggle="modal" data-bs-target="#edit"><img src="https://dreamspos.dreamguystech.com/html/template/assets/img/icons/edit-5.svg" alt="img"></a>
                              </h4>
                              <div class="productlinkset">
                                  <h5>PT001</h5>
                              </div>
                              <div class="increment-decrement">
                                  <div class="input-groups">
                                    <input type="button" value="-" class="button-minus dec button">
                                    <input type="text" name="child" value="${element.qty}" class="quantity-field">
                                    <input type="button" value="+" class="button-plus inc button ">
                                  </div>
                              </div>
                            </div>
                        </div>
                      </li>
                      <li>Rp. ${element.qty * element.harga} </li>
                  </ul>`

                  totall += element.qty * element.harga;
        });
        
        $('#list_produk_terjual').html(elem)
        $('#total-all').html(totall)
    }
  })

}
