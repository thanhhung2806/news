const sanPham = [
    {
        ten: 'iPhone XR',
        dongia: '5000000',
    },
    {
        ten: 'SamSung Glaxy 5G ',
        dongia: '7000000',
    },
    {
        ten: 'Xiaomi Ultra',
        dongia: '9000000',
    },
    {
        ten: 'Oppo Note 8',
        dongia: '1000000',
    },
    {
        ten: 'iPhone 14ProMax',
        dongia: '26000000',
    },
    {
        ten: 'Realme 11',
        dongia: '7000000',
    },
    {
        ten: 'Sony Experia',
        dongia: '6000000',
    },
    {
        ten: 'Vivo 360',
        dongia: '3000000',
    },
    {
        ten: 'SamSung Z Fold 4',
        dongia: '34000000',
    },
    {
        ten: 'SamSung Z Fold 5',
        dongia: '36000000',
    },
]

const nf = new Intl.NumberFormat();
const mucGia = document.getElementById('mucgia')
const bodyTB = document.getElementById('body_tb')
const shop = document.getElementById('shop')
const tongTienEle = document.getElementById('tongtien')
let thanhTienEle

const printBodyTb = (ten, dongia) => {
    bodyTB.innerHTML +=
        `
    <tr>
        <th><input type="checkbox" onchange="changeStatus(this)" ></th>
        <th>${ten}</th>
        <th>${dongia}</th>
        <th><input type="number" onchange="tinhTien(this)" disabled></th>
        <th><span class="tien"></span></th>
    </tr>
`
}
const showSanPham = (gia) => {
    bodyTB.innerHTML = ''
    if (gia == null || isNaN(Number(mucGia.value))) {
        for (let sp of sanPham) {
            printBodyTb(sp.ten, sp.dongia)
        }
    } else {
        gia = Number(gia)
        for (let sp of sanPham) {
            if (sp.dongia <= gia) printBodyTb(sp.ten, sp.dongia)
        }
    }
    thanhTienEle = document.querySelectorAll('.tien')
    tongTienEle.innerHTML = 0
}
showSanPham()

mucGia.oninput = () => {
    let gia = mucGia.value
    showSanPham(gia)
}


const changeStatus = function (check) {
    let row = check.parentElement.parentElement
    let ipSoluong = row.children[3].children[0]
    let thanhTien = row.children[4].children[0]
    ipSoluong.disabled = !ipSoluong.disabled
    tinhTongTien()
    if (check.checked) {
        ipSoluong.value == 0 ? ipSoluong.value = 1 : ipSoluong.value
        tinhTien(check)
    } else {
        thanhTien.innerHTML = ''
    }
    tinhTongTien()
}

const tinhTongTien = function () {
    let tongTien = 0
    Array.from(thanhTienEle).forEach(tt => {
        Number(tt.innerText) == 0 ? tongTien += 0 : tongTien += Number(tt.innerText)
    })
    tongTienEle.innerHTML = nf.format(tongTien)
}

const tinhTien = function (ipSoLuong) {
    let row = ipSoLuong.parentElement.parentElement
    let dongia = row.children[2].innerText
    let soLuong = row.children[3].children[0].value
    let thanhTien = row.children[4].children[0]
    let tien = 0
    tien += soLuong * Number(dongia)
    thanhTien.innerHTML = tien
    tinhTongTien()
}
