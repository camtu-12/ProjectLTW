<template>
  <div class="category-page">
    <div class="wrap">
      <nav class="crumb">Trang chủ  ›  <span>{{ displayName }}</span></nav>

          <div class="category-layout">
            <aside class="sidebar">
              <div class="block">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                  <h4 style="margin:0">Danh mục sản phẩm</h4>
                  <Link href="/danh-muc" class="all-cat">Xem tất cả</Link>
                </div>
                <ul class="cat-list">
                  <li>
                    <Link :href="`/danh-muc/ao-thun-nu`" :class="{ active: slug === 'ao-thun-nu' }">Áo Thun Nữ</Link>
                  </li>
                </ul>
              </div>

              <div class="block">
                <h4>Chọn mức giá</h4>
                <div class="filters">
                  <label class="chk"><input type="checkbox" /> <span> Dưới 200.000đ</span></label>
                  <label class="chk"><input type="checkbox" /> <span> 200.000 - 400.000đ</span></label>
                  <label class="chk"><input type="checkbox" /> <span> 400.000 - 600.000đ</span></label>
                </div>
              </div>

              <div class="block">
                <h4>Kích thước</h4>
                <div class="sizes">
                  <button class="size">XS</button>
                  <button class="size">S</button>
                  <button class="size">M</button>
                  <button class="size">L</button>
                </div>
              </div>
            </aside>

            <main class="main">
              <header class="main-header">
                <div>
                  <h1>{{ displayName }}</h1>
                  <div class="muted" v-if="localProducts && localProducts.length">{{ localProducts.length }} sản phẩm</div>
                </div>
                <div class="tools">Sắp xếp:
                  <select aria-label="Sắp xếp">
                    <option>Mặc định</option>
                    <option value="price_asc">Giá: thấp → cao</option>
                    <option value="price_desc">Giá: cao → thấp</option>
                  </select>
                </div>
              </header>

              <div class="products">
                <div v-for="p in localProducts" :key="p.id" class="product-card">
                  <div class="img-wrap">
                    <img :src="p.img || '/images/placeholder.svg'" :alt="p.title || 'Sản phẩm'" @error="(e)=> e.target.src='/images/placeholder.svg'" />
                    <div class="badge">-10%</div>
                  </div>

                  <div class="meta">
                    <div class="title" :title="p.title">{{ p.title }}</div>
                    <div class="bottom">
                      <div class="price">{{ format(p.price) }}</div>
                      <button class="add" :disabled="adding[p.id]" @click.prevent="addToCart(p)">
                        <span v-if="adding[p.id]">Đang thêm...</span>
                        <span v-else>Thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </main>
          </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: { Link },
  props: {
    slug: { type: String, required: false },
    danhmuc: { type: Object, required: false },
    products: { type: [Array, Object], required: false }
  },
  data() {
    return {
      localProducts: (this.products && this.products.data) ? this.products.data : (this.products || []),
      adding: {},
      // map of sanpham_id -> { id: giohang_id, soluong }
      cartMap: {},
    }
  },
  mounted() {
    // initial load of user's cart to know existing items (so we can PATCH instead of POST)
    ;(async () => {
      try {
        const res = await fetch('/giohang', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
        if (!res.ok) return
        const json = await res.json()
        if (!Array.isArray(json)) return
        // build cartMap
        this.cartMap = {}
        json.forEach(ci => {
          // ci is a giohang row with sanpham_id and soluong
          const pid = ci.sanpham_id || (ci.sanpham && ci.sanpham.id)
          if (pid) this.cartMap[pid] = { id: ci.id, soluong: ci.soluong || 0 }
        })
      } catch (err) {
        console.debug('Failed to load initial cart map', err)
      }
    })()
  },
  computed: {
    displayName() {
      if (this.danhmuc && this.danhmuc.tendanhmuc) return this.danhmuc.tendanhmuc
      if (!this.slug) return 'Danh mục'

      // nice display names for known slugs (with Vietnamese accents)
      const map = {
        'ao-thun-nu': 'Áo Thun Nữ',
        'ao-so-mi-nu': 'Áo Sơ Mi Nữ',
        'vay': 'Váy',
        'ao-kieu-nu': 'Áo Kiểu Nữ'
      }
      if (map[this.slug]) return map[this.slug]

      return this.slug.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
    }
  },
  methods: {
    format(v) { return v ? (v.toLocaleString('vi-VN') + '₫') : '' },
    async addToCart(p) {
      if (!p || !p.id) return;
      // Simple per-product loading state
      this.adding = Object.assign({}, this.adding, { [p.id]: true });

      // (debug) Removed optimistic dispatch to avoid visual duplicates.
      // If you need optimistic UI, we can re-enable it after debugging.
      console.debug('[cart] addToCart start', { productId: p.id })

      const tokenEl = document.querySelector('meta[name="csrf-token"]')
      const csrf = tokenEl ? tokenEl.getAttribute('content') : ''

      try {
        // If product already exists in user's cart, PATCH the existing giohang row
        const existing = this.cartMap[p.id]
        console.debug('[cart] existing map lookup', { productId: p.id, existing })
        if (existing && existing.id) {
          // Product already exists in cart — per requirement, do not add/increment.
          console.debug('[cart] item already in cart, skipping add', { productId: p.id, existing })
          window.alert('Sản phẩm đã có trong giỏ hàng')
          // optionally open the cart UI by dispatching cart:updated with current cart
          await this._refreshCartAndNotify()
        } else {
          // create new cart row
          const res = await fetch('/giohang', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ sanpham_id: p.id, soluong: 1 })
          })

          const json = await res.json().catch(() => null)
          console.debug('[cart] POST /giohang response', { status: res.status, body: json })
          if (res.ok) {
            window.alert(json.message || 'Đã thêm sản phẩm vào giỏ hàng')
            const cartJson = await this._refreshCartAndNotify()
            // Notify listeners and request the cart UI to open with product metadata
            window.dispatchEvent(new CustomEvent('cart:updated', { detail: { cart: cartJson, product: p, open: true } }))
          } else if (res.status === 401) {
            window.alert(json?.message || 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng')
            window.dispatchEvent(new CustomEvent('cart:rollback', { detail: { product: p, qty: 1 } }))
            window.dispatchEvent(new CustomEvent('auth:required'))
          } else {
            window.alert(json?.message || 'Lỗi khi thêm sản phẩm')
            window.dispatchEvent(new CustomEvent('cart:rollback', { detail: { product: p, qty: 1 } }))
          }
        }
      } catch (err) {
        console.error('Add to cart failed', err)
        window.alert('Lỗi khi thêm sản phẩm')
        window.dispatchEvent(new CustomEvent('cart:rollback', { detail: { product: p, qty: 1 } }))
      } finally {
        this.adding = Object.assign({}, this.adding, { [p.id]: false });
      }
    }

    ,
    async _refreshCartAndNotify() {
      try {
        const cartRes = await fetch('/giohang', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
        const cartJson = cartRes.ok ? await cartRes.json() : null
        console.debug('[cart] refreshed cart', { length: Array.isArray(cartJson) ? cartJson.length : null, cart: cartJson })
        // rebuild local cartMap
        this.cartMap = {}
        if (Array.isArray(cartJson)) {
          cartJson.forEach(ci => {
            const pid = ci.sanpham_id || (ci.sanpham && ci.sanpham.id)
            if (pid) this.cartMap[pid] = { id: ci.id, soluong: ci.soluong || 0 }
          })
        }
        window.dispatchEvent(new CustomEvent('cart:updated', { detail: { cart: cartJson } }))
        return cartJson
      } catch (err) {
        console.warn('Failed to refresh cart after add/update', err)
        return null
      }
    }
  }
}
</script>

<style scoped>
.wrap { max-width: 1200px; margin: 18px auto; padding: 0 16px; }
.crumb { color: #6b7280; margin-bottom: 12px }
  .category-layout { display:grid; grid-template-columns: 280px 1fr; gap:32px; align-items:start; }
  .sidebar .block { background:#fff; padding:18px; border-radius:10px; margin-bottom:16px; border:1px solid #eef2f6 }
  .all-cat { color:#6b7280; font-size:13px; text-decoration:none }
  .cat-list li a.active { font-weight:700; background:#f8fafc; padding:6px 8px; border-radius:6px }
  .sidebar h4 { margin:0 0 12px 0; font-size:14px; color:#0f172a; position:relative; padding-left:10px }
  .sidebar h4:before { content:''; width:4px; height:18px; background:#ef4444; position:absolute; left:0; top:6px; border-radius:3px }
  .cat-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:8px }
  .cat-list a { color:#111827; text-decoration:none; padding:6px 8px; border-radius:6px; display:inline-block }
  .cat-list a:hover { background:#f8fafc }

  .filters .chk { display:block; margin-bottom:8px; color:#374151 }
  .sizes { display:flex; gap:8px; flex-wrap:wrap }
  .size { background:#fff; border:1px solid #e6e9ef; padding:6px 10px; border-radius:8px; cursor:pointer }
  .size:hover { background:#f8fafc }

  .main-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px }
  .main-header h1 { font-family:'Playfair Display', serif; font-size:26px; margin:0; color:#0f172a }
  .main-header .muted { color:#6b7280; font-size:13px; margin-top:4px }
  .main-header .tools select { padding:8px 10px; border-radius:6px; border:1px solid #e6e9ef }

  .products { display:grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr)); gap:24px }
  .product-card { background:#fff; border-radius:12px; overflow:hidden; border:1px solid #eef2f6; transition: box-shadow .18s ease, transform .18s ease; display:flex; flex-direction:column }
  .product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(2,6,23,0.06) }
  .img-wrap { width:100%; height:360px; background:#fbfbfc; position:relative; display:flex; align-items:center; justify-content:center }
  .img-wrap img { width:100%; height:100%; object-fit:cover; display:block }
  .img-wrap .badge { position:absolute; right:10px; top:10px; background:linear-gradient(180deg,#ef4444,#dc2626); color:#fff; padding:6px 8px; border-radius:8px; font-size:12px; font-weight:700 }

  .meta { padding:12px 14px; display:flex; flex-direction:column; gap:8px; flex:1 }
  .title { font-weight:600; font-size:14px; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis }
  .bottom { display:flex; justify-content:space-between; align-items:center; gap:12px }
  .price { color:#dc2626; font-weight:800 }
  .add { background:#111827; color:#fff; border:none; padding:8px 12px; border-radius:8px; cursor:pointer }
  .add:hover { opacity:0.95 }
@media (max-width: 900px) {
  .category-layout { grid-template-columns: 1fr; }
  .products { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 600px) {
  .products { grid-template-columns: 1fr; }
  .img-wrap { height:220px }
}

@media (max-width: 420px) {
  .img-wrap { height:160px }
  .product-card .title { white-space: normal; font-size:14px }
  .add { width:100%; padding:10px 12px }
  .products { gap:12px }
}

@media (max-width: 768px) {
  .products { grid-template-columns: repeat(2, 1fr) }
  .img-wrap { height:180px }
}
</style>
