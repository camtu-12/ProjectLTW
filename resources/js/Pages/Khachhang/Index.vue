<template>
  <div class="home-page">

    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
          <div class="logo">THỜI TRANG NỮ</div>
        </div>

        <nav class="nav center-nav">
          <a href="/">Trang chủ</a>

          <div class="nav-item">
            <div class="mega">
              <div class="mega-grid">
                <div class="mega-col">
                  <ul>
                    <li><Link href="/danh-muc/ao-thun-nu">Áo Thun Nữ</Link></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </nav>

        <div class="header-actions">
          <div class="account-wrap">
              <button type="button" class="action-link account-toggle" aria-label="Tài khoản" @click.stop="toggleAccountDropdown">
                <div class="action-icon" aria-hidden>
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5z" stroke="#374151" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="action-label">TÀI KHOẢN</div>
              </button>

              <div class="account-dropdown" v-show="showAccountDropdown" @click.stop>
                <a href="#" class="account-item" @click.prevent="openLoginModal">
                  <span class="icon">🔓</span>
                  <span class="label">Đăng nhập</span>
                </a>
                <a href="#" class="account-item" @click.prevent="openRegisterModal">
                  <span class="icon">👤</span>
                  <span class="label">Đăng ký</span>
                </a>
              </div>
            </div>

          <button type="button" class="action-link action-cart" @click.stop.prevent="toggleCart">
            <div class="action-icon" aria-hidden>
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2l1.5 3h9L18 2H6z" fill="#fff"/><path d="M3 6h18l-1.5 14.5a2 2 0 0 1-2 1.5H6.5a2 2 0 0 1-2-1.5L3 6z" stroke="#374151" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div v-if="cartCount" class="cart-badge">{{ cartCount }}</div>
            <div class="action-label">GIỎ HÀNG</div>
          </button>
        </div>
      </header>

      <!-- CART MODAL / PANEL -->
      <div v-if="showCart" class="cart-backdrop" @click.self="closeCart">
        <div class="cart-panel">
          <h3>Giỏ hàng của bạn</h3>

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

    <!-- BANNER -->
    <section class="banner">
      <img src="/images/banner.jpg" alt="banner" />
    </section>

    <!-- category handled in dedicated Category.vue; inline demo removed -->

    <!-- LOGIN MODAL -->
    <div v-if="showLoginModal" class="login-modal-backdrop" @click.self="closeLoginModal">
      <div class="login-modal">
        <h3>ĐĂNG NHẬP</h3>
        <form class="login-form" @submit.prevent="closeLoginModal">
          <input type="email" placeholder="Email" required />
          <input type="password" placeholder="Mật khẩu" required />
          <div class="login-actions">
            <button type="button" class="btn ghost" @click="closeLoginModal">Hủy</button>
            <button type="submit" class="btn">Đăng nhập</button>
          </div>
        </form>
      </div>
    </div>

    <!-- REGISTER MODAL -->
    <div v-if="showRegisterModal" class="login-modal-backdrop" @click.self="closeRegisterModal">
      <div class="login-modal register-modal">
        <h3>ĐĂNG KÝ</h3>
        <p style="color:#6b7280;margin-bottom:10px;text-align:center">Đã có tài khoản, đăng nhập tại đây</p>
        <form class="login-form" @submit.prevent="submitRegister">
          <input v-model="registerForm.lastName" type="text" placeholder="Họ" required />
          <input v-model="registerForm.firstName" type="text" placeholder="Tên" required />
          <input v-model="registerForm.email" type="email" placeholder="Email" required />
          <input v-model="registerForm.phone" type="text" placeholder="Số điện thoại" required />
          <input v-model="registerForm.password" type="password" placeholder="Mật khẩu" required />
          <div style="margin-top:10px">
            <button type="submit" class="btn" style="width:100%;background:#000">ĐĂNG KÝ</button>
          </div>

          <div style="text-align:center;margin:12px 0;color:#6b7280">Hoặc đăng nhập bằng</div>
          <div style="display:flex;gap:8px;justify-content:center">
            <a href="#" class="social fb">Facebook</a>
            <a href="#" class="social gg">Google</a>
          </div>
        </form>
      </div>
    </div>

    <!-- POLICY BAR -->
    <section class="policy">
      <div class="item">🚚 Miễn phí giao hàng HCM</div>
      <div class="item">⭐ Tích điểm thành viên</div>
      <div class="item">💳 Thanh toán đa dạng</div>
      <div class="item">↩️ 100% hoàn tiền lỗi</div>
    </section>

    <!-- BEST SELLER -->
    <section class="section">
      <h2>Sản phẩm bán chạy</h2>
      <div class="products">
        <Link v-for="p in bestSeller" :key="p.id" :href="`/danh-muc/ao-thun-nu`" class="product-card">
          <img :src="p.img" class="img" />
          <div class="title">{{ p.title }}</div>
          <div class="price">{{ format(p.price) }}</div>
        </Link>
      </div>
    </section>

    <!-- BIG BANNER TEXT -->
    <section class="quote">
     THỜI TRANG NỮ - TÔN VẺ NÉT ĐẸP PHỤ NỮ
      <div class="sub">SINCE 2015</div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
      <div class="col">
        <h4>THỜI TRANG NỮ</h4>
        
        <p>Tên: Nguyễn Thị Cẩm Tú</p>
        <p>Tên: Nguyễn Minh Hiền</p>
        <p>180 Cao Lỗ, Quận 8, TP.HCM</p>
      </div>
      <div class="col">
        <h4>Mã số sinh viên</h4>
        <p>DH52201699</p>
        <p>DH52200662</p>
      </div>
      <div class="col">
        <h4>Lớp</h4>
        <p>D22_TH03</p>
        <p>D22_TH03</p>
      </div>
    </footer>

  </div>
</template>


<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
  components: { Link },
  props: {
    bestSeller: { type: [Array, Object], required: false }
  },
  data() {
    return {
      // If server passed `bestSeller` prop, use that; otherwise fallback to sample data
      bestSeller: (this.bestSeller && this.bestSeller.length) ? this.bestSeller : [
        { id: 1, title: "Áo DK Kim Sweater", price: 860000, img: "/img/p1.jpg" },
        { id: 2, title: "Áo DK Cardigan Đỏ", price: 860000, img: "/img/p2.jpg" },
        { id: 3, title: "Áo DK Grey Sweater", price: 860000, img: "/img/p3.jpg" },
      ],
      newProducts: [
        { id: 4, title: "New Arrival Đẹp", price: 960000, img: "/img/p4.jpg" },
        { id: 5, title: "Sweater Màu Be", price: 860000, img: "/img/p5.jpg" },
        { id: 6, title: "Cardigan Đỏ", price: 860000, img: "/img/p6.jpg" },
      ],
      showCart: false,
      cartItems: [],
      showLoginModal: false,
      showRegisterModal: false,
      registerForm: {
        lastName: '',
        firstName: '',
        email: '',
        phone: '',
        password: ''
      },
      showAccountDropdown: false
    }
  },
  created() {
    // placeholder cart items; in real integration load from server/session
  },
  mounted() {
    document.addEventListener('click', this.onDocumentClick)
    // listen for global cart updates (dispatched after successful non-Inertia add)
    window.addEventListener('cart:updated', this.onCartUpdated)
    window.addEventListener('cart:rollback', this.onCartRollback)
    window.addEventListener('auth:required', () => { this.openLoginModal() })
    // Do NOT auto-load server cart on mount. Cart will be loaded when user
    // opens the cart or when a cart:updated event with server cart is dispatched.
  },
  beforeUnmount() {
    document.removeEventListener('click', this.onDocumentClick)
    window.removeEventListener('cart:updated', this.onCartUpdated)
    window.removeEventListener('cart:rollback', this.onCartRollback)
  },
  computed: {
    cartCount() {
      return this.cartItems.reduce((s, i) => s + (i.qty || 0), 0)
    },
    cartTotal() {
      return this.cartItems.reduce((s, i) => s + (i.qty || 0) * (i.price || 0), 0)
    }
  },
  methods: {
    toggleCart() {
      const willOpen = !this.showCart
      this.showCart = willOpen
      // if opening the cart, load server cart so the user sees current items
      if (willOpen) {
        this.loadCart()
      }
    }
    , closeCart() {
      this.showCart = false
    }
    , async increaseQty(index) {
      if (!this.cartItems[index]) return
      const item = this.cartItems[index]
      const newQty = (item.qty || 0) + 1
      // optimistic UI: mark updating
      this.$set ? this.$set(item, 'updating', true) : (item.updating = true)
      try {
        const tokenEl = document.querySelector('meta[name="csrf-token"]')
        const csrf = tokenEl ? tokenEl.getAttribute('content') : ''
        // If item.id is giohang id, PATCH that row; otherwise fallback to refreshing cart
        if (item && item.id) {
          const res = await fetch(`/giohang/${item.id}`, {
            method: 'PATCH',
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ soluong: newQty })
          })

          if (res.ok) {
            // refresh server cart for canonical data
            await this.loadCart()
          } else if (res.status === 401) {
            window.dispatchEvent(new CustomEvent('auth:required'))
            window.alert('Bạn cần đăng nhập để thay đổi giỏ hàng')
          } else {
            const json = await res.json().catch(() => null)
            console.warn('Failed to update qty', json)
            window.alert(json?.message || 'Lỗi khi cập nhật số lượng')
          }
        }
      } catch (err) {
        console.error('increaseQty error', err)
        window.alert('Lỗi mạng khi cập nhật giỏ hàng')
      } finally {
        if (item) item.updating = false
      }
    }
    , async decreaseQty(index) {
      if (!this.cartItems[index]) return
      const item = this.cartItems[index]
      const current = item.qty || 1
      const newQty = current - 1
      // if newQty < 1 => remove
      if (newQty < 1) {
        return this.removeItem(index)
      }

      this.$set ? this.$set(item, 'updating', true) : (item.updating = true)
      try {
        const tokenEl = document.querySelector('meta[name="csrf-token"]')
        const csrf = tokenEl ? tokenEl.getAttribute('content') : ''
        if (item && item.id) {
          const res = await fetch(`/giohang/${item.id}`, {
            method: 'PATCH',
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ soluong: newQty })
          })

          if (res.ok) {
            await this.loadCart()
          } else if (res.status === 401) {
            window.dispatchEvent(new CustomEvent('auth:required'))
            window.alert('Bạn cần đăng nhập để thay đổi giỏ hàng')
          } else {
            const json = await res.json().catch(() => null)
            console.warn('Failed to update qty', json)
            window.alert(json?.message || 'Lỗi khi cập nhật số lượng')
          }
        }
      } catch (err) {
        console.error('decreaseQty error', err)
        window.alert('Lỗi mạng khi cập nhật giỏ hàng')
      } finally {
        if (item) item.updating = false
      }
    }
    , async removeItem(index) {
      if (!this.cartItems[index]) return
      const item = this.cartItems[index]
      // mark updating to prevent duplicate clicks
      this.$set ? this.$set(item, 'updating', true) : (item.updating = true)
      try {
        const tokenEl = document.querySelector('meta[name="csrf-token"]')
        const csrf = tokenEl ? tokenEl.getAttribute('content') : ''
        if (item && item.id) {
          const res = await fetch(`/giohang/${item.id}`, {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest'
            }
          })

          if (res.ok) {
            // refresh server canonical cart
            await this.loadCart()
          } else if (res.status === 401) {
            window.dispatchEvent(new CustomEvent('auth:required'))
            window.alert('Bạn cần đăng nhập để thay đổi giỏ hàng')
          } else {
            const json = await res.json().catch(() => null)
            console.warn('Failed to delete item', json)
            window.alert(json?.message || 'Lỗi khi xóa sản phẩm')
          }
        } else {
          // fallback: remove local
          this.cartItems.splice(index, 1)
        }
      } catch (err) {
        console.error('removeItem error', err)
        window.alert('Lỗi mạng khi xóa sản phẩm')
      } finally {
        if (item) item.updating = false
      }
    },
    format(v) {
      return v.toLocaleString("vi-VN") + "₫"
    }
    , openLoginModal() {
      this.showLoginModal = true
    }
    , closeLoginModal() {
      this.showLoginModal = false
    }
    , openRegisterModal() {
      this.showRegisterModal = true
    }
    , closeRegisterModal() {
      this.showRegisterModal = false
    }
    , submitRegister() {
      // placeholder: replace with Inertia post to register route
      // simulate success
      alert('Đăng ký (mô phỏng): ' + this.registerForm.email)
      this.showRegisterModal = false
      // reset form
      this.registerForm = { lastName: '', firstName: '', email: '', phone: '', password: '' }
    }
    , toggleAccountDropdown() {
      this.showAccountDropdown = !this.showAccountDropdown
    }
    , closeAccountDropdown() {
      this.showAccountDropdown = false
    }
    , onDocumentClick(e) {
      const wrap = this.$el && this.$el.querySelector('.account-wrap')
      if (!wrap) return
      if (!wrap.contains(e.target)) {
        this.showAccountDropdown = false
      }
    }
    , onCartUpdated(e) {
      try {
        const payload = e && e.detail ? e.detail : null
        if (!payload) return

        // payload may be { server: json, product: p } (we dispatch like that from Category.vue)
        const server = payload.server || payload
        const d = (server && server.data) ? server.data : server

        // product metadata from event (preferred)
        const prod = payload.product || null

        const sanphamId = d && (d.sanpham_id || d.id)
        const qty = d && (d.soluong || d.qty || 1)

        // prefer canonical backend field names (tensanpham, giaban, hinhanh)
        // Prefer explicit product price fields; fallback to the giohang row's `giaban` or the sanpham relation
        const price = prod ? (prod.price || prod.giaban || prod.giagoc || 0) : (d && (d.giaban || (d.sanpham && (d.sanpham.giaban || d.sanpham.giagoc || d.sanpham.gia))) ? (d.giaban || (d.sanpham && (d.sanpham.giaban || d.sanpham.giagoc || d.sanpham.gia))) : 0)
        const title = prod ? (prod.title || prod.tensanpham || prod.ten) : ((d && (d.tensanpham || d.ten)) ? (d.tensanpham || d.ten) : (`Sản phẩm ${sanphamId}`))
        const img = prod ? (prod.img || prod.hinhanh || prod.anh) : '/images/placeholder.svg'

        // If server returned full cart, map it to local items (preferred)
        if (payload.cart && Array.isArray(payload.cart)) {
          // server cart items are models with 'sanpham' relation
          this.cartItems = payload.cart.map(ci => ({
            id: ci.id,
            // map common variants of product fields from backend
            title: (ci.sanpham && (ci.sanpham.tensanpham || ci.sanpham.title || ci.sanpham.ten)) || (`Sản phẩm ${ci.sanpham_id}`),
            size: ci.size || 'S',
            color: ci.color || '',
            // Use unit price from giohang row (`giaban`) when available, otherwise use sanpham price fields
            price: (ci.giaban) || (ci.sanpham && (ci.sanpham.giaban || ci.sanpham.giagoc || ci.sanpham.price || ci.sanpham.gia)) || 0,
            qty: ci.soluong || 1,
            // image may be stored on the giohang row or in the sanpham relation
            img: (ci.hinhanh) || (ci.sanpham && (ci.sanpham.hinhanh || ci.sanpham.img || ci.sanpham.anh)) || '/images/placeholder.svg'
          }))
        } else {
          // if already in cart, update qty; otherwise push new item
          const idx = this.cartItems.findIndex(i => String(i.id) === String(sanphamId))
          if (idx >= 0) {
            this.cartItems[idx].qty = (this.cartItems[idx].qty || 0) + (qty || 1)
          } else {
            this.cartItems.push({ id: sanphamId, title, size: (d && d.size) || 'S', color: (d && d.color) || '', price: price || 0, qty: qty || 1, img })
          }
        }

        // Do not auto-open the cart on cart updates.
        // The cart UI should appear only when the user explicitly clicks the cart button.
        // If the updater requested the cart to open (e.g. after Add), honor it.
        if (payload && payload.open) {
          this.showCart = true
        }
      } catch (err) {
        console.error('onCartUpdated error', err)
      }
    }
    , async loadCart() {
      try {
        const res = await fetch('/giohang', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
        if (!res.ok) return
        const json = await res.json()
        if (Array.isArray(json)) {
          // reuse the same mapping logic as onCartUpdated
          window.dispatchEvent(new CustomEvent('cart:updated', { detail: { cart: json } }))
        }
      } catch (err) {
        console.debug('loadCart failed', err)
      }
    }
    , onCartRollback(e) {
      try {
        const payload = e && e.detail ? e.detail : null
        if (!payload || !payload.product) return
        const prod = payload.product
        const qty = payload.qty || 1

        const idx = this.cartItems.findIndex(i => String(i.id) === String(prod.id))
        if (idx === -1) return
        // decrement or remove
        if ((this.cartItems[idx].qty || 0) > qty) {
          this.cartItems[idx].qty = (this.cartItems[idx].qty || 0) - qty
        } else {
          this.cartItems.splice(idx, 1)
        }
      } catch (err) {
        console.error('onCartRollback error', err)
      }
    }
  }
}
</script>


<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@500;700&display=swap');

/* RESET */
* { box-sizing: border-box; }

.home-page {
  font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
  color: #1f2937;
  background: #fff;
}

.header {
  max-width: 1200px;
  margin: 0 auto;
  padding: 22px 20px;
  display: grid;
  grid-template-columns: auto 1fr auto;
  align-items: center;
  column-gap: 20px;
  border-bottom: 1px solid #f1f5f9;
}
.logo {
  font-size: 26px;
  font-family: 'Playfair Display', serif;
  font-weight: 700;
  color: var(--brand, #111827);
}
.nav a {
  margin: 0 10px;
  text-decoration: none;
  color: #374151;
  font-size: 14px;
  padding: 8px 10px;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  line-height: 1;
}
.nav a:hover { background: #f8fafc; color: #111827; }

/* header layout helpers */
.header-left { display:flex; align-items:center; gap:22px; grid-column: 1 / 2 }
.nav { display:flex; gap:20px; align-items:center }
.nav > a, .nav .mega ul li a, .nav-link { display:inline-flex; align-items:center; padding:8px 10px; color:#374151; border-radius:6px; font-size:14px; line-height:1 }
.nav a:hover, .nav-link:hover { background:#f8fafc; color:#111827; }

/* Ensure megamenu links match top-level nav links for consistent alignment */
.nav .mega { display: block; }
.nav .mega ul { margin: 0; padding: 0; list-style: none; display: flex; gap: 12px; align-items: center; }
.nav .mega ul li { margin: 0; }
.nav .mega ul li a { display: inline-flex; align-items: center; padding: 8px 10px; color: #374151; font-size: 14px; text-decoration: none; border-radius: 6px; }
.nav .mega ul li a:hover { background:#f8fafc; color:#111827 }
.header-actions { display:flex; align-items:center; gap:18px; grid-column: 3 / 4; justify-self: end }

/* place center nav in middle column and center it */
.center-nav { grid-column: 2 / 3; justify-self: center; display:flex; gap:20px; align-items:center }

@media (max-width: 1024px) {
  /* Revert to flex layout on narrower screens for a simpler flow */
  .header { display:flex; justify-content:space-between; }
  .center-nav { grid-column: auto; justify-self: auto; }
}
.action-link { display:flex; flex-direction:column; align-items:center; text-decoration:none; color:#374151; font-size:12px; }
.action-icon { width:56px; height:56px; border-radius:9999px; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #eef2ff; box-shadow:0 2px 6px rgba(2,6,23,0.06); }
.action-label { margin-top:6px; font-weight:600; font-size:12px; color:#111827; }
.action-cart { position:relative; }
.cart-badge { position:absolute; top:0; right:6px; transform:translate(50%,-30%); background:#111827; color:#fff; font-size:11px; padding:4px 6px; border-radius:12px; }

/* Account dropdown */
.account-wrap { position: relative; }
.account-toggle { background: transparent; border: none; cursor: pointer; padding: 0; }
.account-dropdown { position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border-radius: 10px; box-shadow: 0 12px 30px rgba(2,6,23,0.12); padding: 6px 0; min-width: 170px; z-index: 120; }
.account-item { display:flex; align-items:center; gap:10px; padding:10px 14px; color:#0f172a; text-decoration:none; font-weight:600; font-size:14px; }
.account-item:hover { background:#f8fafc; }
.account-item .icon { width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; }

/* show dropdown via JS toggle (hover CSS removed to avoid accidental hide) */

/* login modal */
.login-modal-backdrop { position: fixed; inset: 0; background: rgba(2,6,23,0.45); display:flex; align-items:center; justify-content:center; z-index:200; }
.login-modal { width: 420px; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 30px 80px rgba(2,6,23,0.16); }
.login-modal h3 { margin: 0 0 10px 0; font-family:'Playfair Display', serif; }
.login-form { display:flex; flex-direction:column; gap:10px; }
.login-form input { height:44px; padding:10px 12px; border:1px solid #e6e9ef; border-radius:6px; }
.login-actions { display:flex; justify-content:space-between; align-items:center; margin-top:8px; }
.btn { background:#0f172a; color:#fff; padding:8px 14px; border-radius:6px; border:none; cursor:pointer; }
.btn.ghost { background:transparent; color:#0f172a; border:1px solid #e6e9ef; }
/* register modal tweaks */
.register-modal { width: 460px; }
.social { display:inline-flex; align-items:center; justify-content:center; padding:8px 16px; border-radius:6px; color:#fff; text-decoration:none; font-weight:600; }
.social.fb { background:#3b5998 }
.social.gg { background:#db4a39 }
/* Improve megamenu alignment: show centered under the nav item and avoid full-width overflow */
.nav-item { position:relative; }
.mega { display:none; position:absolute; top:calc(100% + 8px); left:0; min-width:640px; max-width:760px; background:#fff; padding:18px; border-radius:8px; box-shadow:0 10px 30px rgba(2,6,23,0.08); z-index:80; }
.nav-item:hover > .mega { display:block; }
.mega-grid { display:grid; grid-template-columns:repeat(3, 1fr); gap:18px; }

/* Make sure megamenu doesn't go off-screen on the right */
.header { position:relative; }
.nav-item .mega { right:auto; left: -12px; }

@media (max-width: 900px){
  .nav { flex-wrap:wrap; gap:12px; }
  .nav-item .mega { position:static; display:none; width:100%; box-shadow:none; padding:12px 0; }
  .nav-item:hover > .mega { display:block; }
  .mega-grid { grid-template-columns:repeat(2,1fr); }
}

/* MEGA MENU */
.nav { position: relative; }
.nav-item { position:relative; }
.nav-link { display:inline-block; padding:6px 8px; }
.mega {
  /* Always visible: show submenu inline under the nav label */
  display: block !important;
  position: static !important;
  left: auto;
  top: auto;
  width: auto !important;
  background: transparent !important;
  padding: 0 !important;
  border-radius: 0 !important;
  box-shadow: none !important;
  z-index: 1;
}
.nav-item:hover > .mega { display: block; }
.mega-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.mega-col h4 { font-size: 13px; font-weight:700; margin-bottom:8px; color:#111827; }
.mega-col ul { list-style:none; padding:0; margin:0; }
.mega-col li { margin-bottom:8px; }
.mega-col a { color:#4b5563; text-decoration:none; font-size:13px; }
.mega-col a:hover { color:#111827; }

@media (max-width: 900px){
  /* On small screens keep megamenu visible but stacked */
  .mega { left: 10px; right: 10px; width: auto; background: #fff; padding: 12px; box-shadow: 0 10px 30px rgba(2,6,23,0.08); border-radius:8px }
  .mega-grid { grid-template-columns: repeat(2, 1fr); }
}

/* BANNER */
.banner { max-width: 1200px; margin: 18px auto; }
.banner img {
  width: 100%;
  height: 380px;
  object-fit: cover;
  border-radius: 10px;
  display: block;
}

/* POLICY */
.policy {
  max-width: 1200px;
  margin: 18px auto;
  display: flex;
  justify-content: space-between;
  gap: 12px;
  padding: 12px 16px;
  background: #f8fafc;
  border-radius: 8px;
}
.policy .item { font-size: 13px; color: #374151; }

/* SECTIONS */
.section { max-width: 1200px; margin: 30px auto; padding: 0 12px; }
.section h2 {
  text-align: left;
  margin-bottom: 18px;
  font-size: 22px;
  font-weight: 700;
  font-family: 'Playfair Display', serif;
  color: #0f172a;
}

/* PRODUCTS - responsive grid */
.products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 28px;
}
.product-card {
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  transition: transform .28s ease, box-shadow .28s ease;
  border: 1px solid #f1f5f9;
}
.product-card:hover { transform: translateY(-6px); box-shadow: 0 10px 30px rgba(2,6,23,0.08); }
.product-card .img { width: 100%; height: 320px; object-fit: cover; display:block; }
.product-card .title { padding: 12px 14px 6px 14px; font-weight:600; color:#0f172a; }
.product-card .price { padding: 0 14px 14px 14px; color: #dc2626; font-weight: 700; }

/* Category layout */
.category-page { max-width: 1200px; margin: 18px auto; }
.category-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
.category-body { display:grid; grid-template-columns: 260px 1fr; gap:24px; }
.sidebar .block { background:#fff; padding:14px; border-radius:8px; margin-bottom:12px; border:1px solid #f1f5f9 }
.sidebar h4 { margin:0 0 10px 0; font-size:14px; }
.small-link { display:inline-block; margin-bottom:8px; color:#6b7280; font-size:13px }
.category-title { margin:0 0 12px 0; font-family:'Playfair Display', serif; font-size:20px }
.grid-3 { display:grid; grid-template-columns: repeat(3, 1fr); gap:20px }

@media (max-width: 900px){
  .category-body { grid-template-columns: 1fr; }
  .grid-3 { grid-template-columns: repeat(2, 1fr); }
}

/* small product meta */
.meta { padding: 0 14px 8px 14px; color: #6b7280; font-size: 13px; }

/* QUOTE / BIG BANNER TEXT */
.quote { max-width: 1200px; margin: 36px auto; padding: 40px 16px; text-align: center; background: linear-gradient(180deg,#fff7f8,#fff); border-radius: 8px; }
.quote { font-family: 'Playfair Display', serif; font-size: 28px; color: #0f172a; }
.quote .sub { margin-top: 8px; font-size: 14px; color: #6b7280; }

/* FOOTER */
.footer { margin-top: 40px; padding: 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 20px; background: #0f172a; color: #fff; }
.footer h4 { margin-bottom: 12px; }

/* tiny responsive tweaks */
@media (max-width: 768px){
  .banner img { height: 220px; }
  .product-card .img { height: 220px; }
  .header { padding: 14px 12px; }
  .policy { padding: 10px; gap: 8px; }
}

/* CART PANEL */
.cart-backdrop { position: fixed; inset: 0; background: rgba(2,6,23,0.35); display:flex; align-items:flex-start; justify-content:center; padding:40px 16px; z-index:300; }
.cart-panel { width: 980px; max-width: calc(100% - 40px); background:#fff; border-radius:10px; padding:18px; box-shadow:0 30px 80px rgba(2,6,23,0.14); }
.cart-panel h3 { margin:0 0 12px 0; font-family:'Playfair Display', serif; }
.cart-table { border:1px solid #eef2f6; border-radius:8px; overflow:hidden; background:#fff; }
.cart-head, .cart-row { display:grid; grid-template-columns: 1fr 110px 160px 160px; gap:12px; align-items:center; padding:16px; border-bottom:1px solid #f3f6f8; }
.cart-head { background:#fbfbfd; font-weight:700; color:#6b7280; text-transform:uppercase; font-size:13px; }
.cart-row .product { display:flex; gap:12px; align-items:center; }
.cart-row .thumb { width:92px; height:92px; object-fit:cover; border-radius:6px; border:1px solid #f1f5f9; }
.cart-row .meta { font-size:13px; color:#374151; }
.cart-row .meta .title { font-weight:700; margin-bottom:6px; }
.link-btn { background:transparent; border:none; color:#6b7280; margin-left:8px; cursor:pointer; }
.qty-control { display:inline-flex; align-items:center; gap:8px; }
.btn-qty { width:28px; height:28px; border-radius:6px; border:1px solid #e6e9ef; background:#fff; cursor:pointer; }
.qty-input { width:44px; text-align:center; border:1px solid #eef2f6; height:32px; border-radius:6px; }
.cart-footer { display:flex; justify-content:space-between; align-items:center; margin-top:12px; }
.cart-footer .summary { margin-right:12px; font-weight:700; color:#111827; }
.btn.checkout { background:#000; color:#fff; padding:12px 20px; border-radius:6px; }

@media (max-width: 900px){
  .cart-panel { width: 100%; padding:12px; }
  .cart-head, .cart-row { grid-template-columns: 1fr 90px 120px 120px; }
  .cart-row .thumb { width:72px; height:72px }
}

/* Additional responsive rules */
@media (max-width: 1024px) {
  .nav { display: none; }
  .center-nav { display: none; }
  .header { padding: 12px; }
}

@media (max-width: 768px) {
  .header { flex-direction: column; align-items: stretch; gap: 8px; }
  .header-left { width: 100%; display:flex; justify-content:space-between; align-items:center }
  .header-actions { width: 100%; display:flex; justify-content: flex-end; gap: 10px }
  .banner img { height: 180px; }
  .product-card .img { height: 180px }
  .products { gap: 14px }
  .cart-backdrop { align-items:flex-end; padding:0 }
  .cart-panel { width: 100%; max-width: 100%; border-radius: 12px 12px 0 0; height: 75vh; overflow:auto }
  .cart-head, .cart-row { grid-template-columns: 1fr 80px 100px 100px }
}

@media (max-width: 420px) {
  .product-card .img { height: 140px }
  .cart-head, .cart-row { grid-template-columns: 1fr 70px 90px 90px }
  .cart-row .thumb { width:56px; height:56px }
  .action-icon { width:44px; height:44px }
  .action-label { font-size:11px }
}

</style>
