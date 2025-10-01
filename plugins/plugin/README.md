# Conifer Features Plugin

Plugin WordPress tùy chỉnh cho theme Conifer với các tính năng: đổi logo, slider, form liên hệ, gallery, và rating system.

## Tính năng

### 1. Logo Management
- Tùy chỉnh logo chính và logo footer
- Điều chỉnh kích thước logo
- Tích hợp với WordPress Customizer

**Cách sử dụng:**
- Vào `Appearance > Customize > Logo Settings`
- Upload logo và điều chỉnh kích thước

### 2. Slider
- Tạo và quản lý slider với nhiều hình ảnh
- Hỗ trợ autoplay, navigation, dots
- Responsive design
- Touch/swipe support

**Cách sử dụng:**
- Vào `Sliders` trong admin menu
- Tạo slider mới và thêm hình ảnh
- Sử dụng shortcode: `[conifer_slider id="slider_id"]`

### 3. Contact Form
- Form liên hệ với validation
- Gửi email tự động
- Auto-reply cho người dùng
- Lưu trữ submissions trong admin

**Cách sử dụng:**
- Sử dụng shortcode: `[conifer_contact_form]`
- Xem submissions tại `Conifer Features > Contact Submissions`

### 4. Gallery
- Tạo gallery với nhiều hình ảnh
- Hỗ trợ lightbox
- Responsive grid layout
- Tùy chỉnh số cột và kích thước hình

**Cách sử dụng:**
- Vào `Galleries` trong admin menu
- Tạo gallery mới và thêm hình ảnh
- Sử dụng shortcode: `[conifer_gallery id="gallery_id"]`

### 5. Rating System
- Hệ thống đánh giá 5 sao
- Hiển thị điểm trung bình
- Chỉ cho phép user đã đăng nhập đánh giá
- Lưu trữ ratings trong database

**Cách sử dụng:**
- Sử dụng shortcode: `[conifer_rating]`
- Xem ratings tại `Conifer Features > Ratings`

## Cài đặt

1. Upload thư mục `plugin` vào `/wp-content/plugins/`
2. Kích hoạt plugin trong WordPress admin
3. Cấu hình các tính năng theo nhu cầu

## Shortcodes

### Slider
```
[conifer_slider id="1" class="my-slider"]
```

### Contact Form
```
[conifer_contact_form title="Liên hệ" show_phone="true" show_subject="true"]
```

### Gallery
```
[conifer_gallery id="1" class="my-gallery"]
```

### Rating
```
[conifer_rating post_id="123" show_average="true" show_count="true" allow_rating="true"]
```

## Cấu hình

### Admin Settings
- Vào `Conifer Features > Settings`
- Cấu hình email nhận form liên hệ
- Bật/tắt auto-reply

### Customizer
- Vào `Appearance > Customize > Logo Settings`
- Tùy chỉnh logo và kích thước

## Database

Plugin tạo các bảng sau:
- `wp_conifer_ratings` - Lưu trữ ratings
- `wp_conifer_contact_submissions` - Lưu trữ form submissions

## Hooks và Filters

### Actions
- `conifer_features_init` - Khởi tạo plugin
- `conifer_rating_submitted` - Khi user đánh giá
- `conifer_contact_form_submitted` - Khi form được gửi

### Filters
- `conifer_rating_average` - Tùy chỉnh tính toán điểm trung bình
- `conifer_contact_form_fields` - Tùy chỉnh fields form liên hệ

## Styling

Plugin bao gồm CSS responsive cho tất cả tính năng:
- `assets/css/style.css` - Styles chính
- `assets/css/slider.css` - Styles slider
- `assets/css/contact.css` - Styles form liên hệ
- `assets/css/gallery.css` - Styles gallery
- `assets/css/rating.css` - Styles rating
- `assets/css/lightbox.css` - Styles lightbox

## JavaScript

Plugin bao gồm JavaScript cho tất cả tính năng:
- `assets/js/script.js` - JavaScript chính
- `assets/js/slider.js` - JavaScript slider
- `assets/js/contact.js` - JavaScript form liên hệ
- `assets/js/gallery.js` - JavaScript gallery
- `assets/js/rating.js` - JavaScript rating
- `assets/js/lightbox.js` - JavaScript lightbox

## Yêu cầu hệ thống

- WordPress 5.0+
- PHP 7.4+
- MySQL 5.6+

## Hỗ trợ

Nếu gặp vấn đề, vui lòng kiểm tra:
1. Plugin đã được kích hoạt
2. Các file CSS/JS đã được load
3. Database tables đã được tạo
4. User có quyền cần thiết

## Phiên bản

- Version: 1.0.0
- Author: Your Name
- License: GPL v2 or later
