<template>
  <div class="cart-page">
    <div class="container">
      <h2>Giỏ hàng</h2>

      <div class="cart-table">
        <div class="cart-head">
          <div class="col product">THÔNG TIN SẢN PHẨM</div>
          <div class="col price">ĐƠN GIÁ</div>
          <div class="col qty">SỐ LƯỢNG</div>
          <div class="col total">THÀNH TIỀN</div>
        </div>

        <div v-for="(item, idx) in cartItems" :key="item.id" class="cart-row">
          <div class="col product">
            <img :src="item.img" alt="" class="thumb" />
            <div class="meta">
              <div class="title">{{ item.title }}</div>
              <div class="props">{{ item.size }} / {{ item.color }} <button class="link-btn" @click.prevent="removeItem(idx)">Xóa</button></div>
            </div>
          </div>

          <div class="col price">{{ format(item.price) }}</div>

          <div class="col qty">
            <div class="qty-control">
              <button type="button" class="btn-qty" @click="decreaseQty(idx)">-</button>
              <input type="text" class="qty-input" :value="item.qty" readonly />
              <button type="button" class="btn-qty" @click="increaseQty(idx)">+</button>
            </div>
          </div>

          <div class="col total">{{ format(item.price * item.qty) }}</div>
        </div>

      </div>

      <div class="cart-footer">
        <div class="left">Tiếp tục mua hàng</div>
        <div class="right">
          <div class="summary">TỔNG TIỀN: <span class="amount">{{ format(cartTotal) }}</span></div>
          <button class="btn checkout">THANH TOÁN</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CartPage',
  data() {
    return {
      cartItems: [
        {
          id: 'rr25ak109',
          title: 'Áo Kiểu Nữ Elly Top RR25AK109',
          size: 'S',
          color: 'Xám Sọc',
          price: 500000,
          qty: 2,
          img: '/img/p1.jpg'
        }
      ]
    }
  },
  computed: {
    cartTotal() {
      return this.cartItems.reduce((s, i) => s + (i.qty || 0) * (i.price || 0), 0)
    }
  },
  methods: {
    format(v) { return v.toLocaleString('vi-VN') + '₫' },
    increaseQty(i) { if (this.cartItems[i]) this.cartItems[i].qty = (this.cartItems[i].qty || 0) + 1 },
    decreaseQty(i) { if (!this.cartItems[i]) return; if (this.cartItems[i].qty > 1) this.cartItems[i].qty -= 1 },
    removeItem(i) { if (!this.cartItems[i]) return; this.cartItems.splice(i, 1) }
  }
}
</script>

<style scoped>
.container { max-width: 980px; margin: 18px auto; }
.cart-table { border:1px solid #eef2f6; border-radius:8px; overflow:hidden; background:#fff; }
.cart-head, .cart-row { display:grid; grid-template-columns: 1fr 110px 160px 160px; gap:12px; align-items:center; padding:16px; border-bottom:1px solid #f3f6f8; }
.cart-head { background:#fbfbfd; font-weight:700; color:#6b7280; text-transform:uppercase; font-size:13px; }
.cart-row .product { display:flex; gap:12px; align-items:center; }
.thumb { width:92px; height:92px; object-fit:cover; border-radius:6px; border:1px solid #f1f5f9; }
.meta { font-size:13px; color:#374151; }
.meta .title { font-weight:700; margin-bottom:6px; }
.link-btn { background:transparent; border:none; color:#6b7280; margin-left:8px; cursor:pointer; }
.qty-control { display:inline-flex; align-items:center; gap:8px; }
.btn-qty { width:28px; height:28px; border-radius:6px; border:1px solid #e6e9ef; background:#fff; cursor:pointer; }
.qty-input { width:44px; text-align:center; border:1px solid #eef2f6; height:32px; border-radius:6px; }
.cart-footer { display:flex; justify-content:space-between; align-items:center; margin-top:12px; }
.cart-footer .summary { margin-right:12px; font-weight:700; color:#111827; }
.btn.checkout { background:#000; color:#fff; padding:12px 20px; border-radius:6px; }
@media (max-width: 900px){ .cart-head, .cart-row { grid-template-columns: 1fr 90px 120px 120px } .thumb { width:72px; height:72px } }
</style>
<template>
  <div class="wrap cart-page">
    <nav class="crumb">Trang chủ  ›  <span>Giỏ hàng</span></nav>

    <h2>Giỏ hàng của bạn</h2>

    <div class="cart-layout">
      <div class="cart-table">
        <div class="thead">
          <div class="col item">THÔNG TIN SẢN PHẨM</div>
          <div class="col price">ĐƠN GIÁ</div>
          <div class="col qty">SỐ LƯỢNG</div>
          <div class="col total">THÀNH TIỀN</div>
        </div>

        <div v-if="localItems.length === 0" class="empty">Giỏ hàng trống — <Link href="/">Tiếp tục mua hàng</Link></div>

        <div v-for="it in localItems" :key="it.id" class="row">
          <div class="col item">
            <div class="media">
              <img :src="it.img" alt="" />
              <div class="meta">
                <div class="title">{{ it.title }}</div>
                <div class="muted">{{ it.variant || 'S / Xám Sọc' }}</div>
                <div class="remove"><a href="#" @click.prevent="remove(it)">Xóa</a></div>
              </div>
            </div>
          </div>

          <div class="col price">{{ format(it.price) }}</div>

          <div class="col qty">
            <div class="qty-controls">
              <button class="minus" @click.prevent="decQty(it)">-</button>
              <input type="text" :value="it.soluong" readonly />
              <button class="plus" @click.prevent="incQty(it)">+</button>
            </div>
          </div>

          <div class="col total">{{ format(it.tongtien || it.price * it.soluong) }}</div>
        </div>
      </div>

      <aside class="summary">
        <div class="box">
          <div class="row">
            <div>TỔNG TIỀN:</div>
            <div class="amount">{{ format(totalComputed) }}</div>
          </div>
          <div style="margin-top:14px">
            <Link href="/donhang" class="checkout">THANH TOÁN</Link>
          </div>
        </div>
      </aside>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: { Link },
  props: {
    items: { type: Array, default: () => [] },
    total: { type: Number, default: 0 }
  },
  data() {
    return {
      localItems: this.items ? [...this.items] : []
    }
  },
  computed: {
    totalComputed() {
      return this.localItems.reduce((s, it) => s + (Number(it.tongtien || it.price * it.soluong) || 0), 0)
    }
  },
  methods: {
    format(v) { return v ? (Number(v).toLocaleString('vi-VN') + '₫') : '0₫' },
    incQty(it) {
      const newQty = (Number(it.soluong) || 0) + 1
      this.updateQty(it, newQty)
    },
    decQty(it) {
      const newQty = Math.max(1, (Number(it.soluong) || 1) - 1)
      this.updateQty(it, newQty)
    },
    updateQty(it, qty) {
      Inertia.patch(`/giohang/${it.id}`, { soluong: qty }, {
        onSuccess: (page) => {
          // optimistic update: update localItems from returned data if any, otherwise adjust locally
          const idx = this.localItems.findIndex(x => x.id === it.id)
          if (idx !== -1) {
            this.localItems[idx].soluong = qty
            const price = this.localItems[idx].price || 0
            this.localItems[idx].tongtien = price * qty
          }
        }
      })
    },
    remove(it) {
      if (!confirm('Bạn có chắc muốn xóa sản phẩm khỏi giỏ hàng?')) return;
      Inertia.delete(`/giohang/${it.id}`, {
        onSuccess: () => {
          this.localItems = this.localItems.filter(x => x.id !== it.id)
        }
      })
    }
  }
}
</script>

<style scoped>
.wrap { max-width: 1100px; margin: 18px auto; padding: 0 16px }
.crumb { color:#6b7280; margin-bottom:12px }
.cart-layout { display:grid; grid-template-columns: 1fr 320px; gap:20px; align-items:start }
.cart-table { background:#fff; border:1px solid #eef2f6; border-radius:10px; padding:14px }
.thead { display:grid; grid-template-columns: 1fr 120px 120px 120px; gap:8px; padding:10px 6px; border-bottom:1px solid #f1f5f9; font-weight:700; color:#374151 }
.row { display:grid; grid-template-columns: 1fr 120px 120px 120px; gap:8px; padding:14px 6px; align-items:center; border-bottom:1px solid #fbfbfb }
.media { display:flex; gap:12px; align-items:center }
.media img { width:84px; height:100px; object-fit:cover; border-radius:6px }
.meta .title { font-weight:700; color:#0f172a }
.muted { color:#6b7280; font-size:13px }
.remove { margin-top:6px }
.qty-controls { display:flex; align-items:center; gap:8px }
.qty-controls input { width:46px; text-align:center; border:1px solid #e6e9ef; height:34px; border-radius:6px }
.qty-controls button { width:32px; height:32px; border-radius:6px; border:1px solid #e6e9ef; background:#fff }
.summary .box { background:#fff; padding:18px; border-radius:10px; border:1px solid #eef2f6 }
.summary .amount { color:#dc2626; font-weight:800 }
.checkout { display:inline-block; width:100%; background:#111827; color:#fff; text-align:center; padding:12px 16px; border-radius:8px; text-decoration:none }
.empty { padding:18px; color:#6b7280 }
@media (max-width: 900px) { .cart-layout { grid-template-columns: 1fr } .thead { display:none } .row { grid-template-columns: 1fr } .summary { order:2 } }
</style>
