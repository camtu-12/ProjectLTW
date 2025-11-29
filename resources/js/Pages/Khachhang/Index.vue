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
            <a class="nav-link">Danh mục</a>

            <div class="mega">
              <div class="mega-grid">
                <div class="mega-col">
                  <h4>ÁO NỮ</h4>
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

          <a href="/cart" class="action-link action-cart">
            <div class="action-icon" aria-hidden>
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2l1.5 3h9L18 2H6z" fill="#fff"/><path d="M3 6h18l-1.5 14.5a2 2 0 0 1-2 1.5H6.5a2 2 0 0 1-2-1.5L3 6z" stroke="#374151" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="cart-badge">{{ cartCount }}</div>
            <div class="action-label">GIỎ HÀNG</div>
          </a>
        </div>
      </header>

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
      <h2>Sản phẩm mới</h2>
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
      cartCount: 0,
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
    // placeholder cart count; replace with real data when integrating
    this.cartCount = 0
  },
  mounted() {
    document.addEventListener('click', this.onDocumentClick)
  },
  beforeUnmount() {
    document.removeEventListener('click', this.onDocumentClick)
  },
  methods: {
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

/* HEADER */
.header {
  max-width: 1200px;
  margin: 0 auto;
  padding: 22px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
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
  padding: 6px 8px;
  border-radius: 6px;
}
.nav a:hover { background: #f8fafc; color: #111827; }

/* header layout helpers */
.header-left { display:flex; align-items:center; gap:22px; }
.nav { display:flex; gap:20px; align-items:center; }
.nav a, .nav-link { display:inline-flex; align-items:center; padding:8px 10px; color:#374151; border-radius:6px; font-size:14px; }
.nav a:hover, .nav-link:hover { background:#f8fafc; color:#111827; }
.header-actions { display:flex; align-items:center; gap:18px; }
.center-nav { flex: 1; justify-content: center; }
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
.nav-item { position: relative; }
.nav-link { display:inline-block; padding:6px 8px; }
.mega {
  display: none;
  position: absolute;
  left: 0;
  top: calc(100% + 8px);
  width: 720px;
  background: #fff;
  padding: 18px;
  border-radius: 8px;
  box-shadow: 0 10px 30px rgba(2,6,23,0.08);
  z-index: 80;
}
.nav-item:hover > .mega { display: block; }
.mega-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.mega-col h4 { font-size: 13px; font-weight:700; margin-bottom:8px; color:#111827; }
.mega-col ul { list-style:none; padding:0; margin:0; }
.mega-col li { margin-bottom:8px; }
.mega-col a { color:#4b5563; text-decoration:none; font-size:13px; }
.mega-col a:hover { color:#111827; }

@media (max-width: 900px){
  .mega { left: 10px; right: 10px; width: auto; }
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

</style>
