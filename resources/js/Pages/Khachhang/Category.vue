<template>
  <div class="category-page">
    <div class="wrap">
      <nav class="crumb">Trang chủ  ›  <span>{{ displayName }}</span></nav>

          <div class="category-layout">
            <aside class="sidebar">
              <div class="block">
                <h4>Danh mục sản phẩm</h4>
                <ul class="cat-list">
                  <li><Link href="/danh-muc/ao-thun-nu">Áo Thun Nữ</Link></li>
                  <li><Link href="/danh-muc/ao-so-mi-nu">Áo Sơ Mi Nữ</Link></li>
                  <li><Link href="/danh-muc/vay">Váy</Link></li>
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
                  <div class="muted" v-if="products && products.total">{{ products.total }} sản phẩm</div>
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
                      <button class="add">Thêm</button>
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

export default {
  components: { Link },
  props: {
    slug: { type: String, required: false },
    danhmuc: { type: Object, required: false },
    products: { type: [Array, Object], required: false }
  },
  data() {
    return {
      localProducts: (this.products && this.products.data) ? this.products.data : (this.products || [])
    }
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
    format(v) { return v ? (v.toLocaleString('vi-VN') + '₫') : '' }
  }
}
</script>

<style scoped>
.wrap { max-width: 1200px; margin: 18px auto; padding: 0 16px; }
.crumb { color: #6b7280; margin-bottom: 12px }
  .category-layout { display:grid; grid-template-columns: 280px 1fr; gap:32px; align-items:start; }
  .sidebar .block { background:#fff; padding:18px; border-radius:10px; margin-bottom:16px; border:1px solid #eef2f6 }
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
  .img-wrap { width:100%; height:280px; background:#fbfbfc; position:relative; display:flex; align-items:center; justify-content:center }
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
</style>
