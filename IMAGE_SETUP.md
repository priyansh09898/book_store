# BookStore - Image Setup Guide

## How to Add Images for Books

### Option 1: Manual Image Upload (Recommended)

1. **Create or ensure `img` folder exists**:
   - Path: `c:\xammpp1\htdocs\bookstore\img\`
   - Create if it doesn't exist

2. **Add your book images**:
   - Place image files in the `img/` folder
   - Supported formats: JPG, PNG, GIF, WebP
   - Recommended size: 240px width × 320px height (or similar aspect ratio)
3. **Update image names in database**:
   - When adding a book in admin panel, upload the image
   - The system will store the image in `img/` folder

### Option 2: Add Images to Existing Books

If you've already added books without images, you can:

1. **Manually place images in `img/` folder**
2. **Update database image field** via phpMyAdmin:
   - Go to `bookstore` database
   - Select `books` table
   - Edit book records and change `image` field to match filename
   - Example: `book1.jpg`, `fiction.png`, etc.

### Sample Book Images List

To use sample images, save these files in `img/` folder:

- `book1.jpg` (The Alchemist)
- `book2.jpg` (Rich Dad Poor Dad)
- `book3.jpg` (Atomic Habits)
- `book4.jpg` (Think and Grow Rich)
- `book5.jpg` (Wings of Fire)

### Image Path Format

When adding images through admin panel or database:

- **Correct formats**:
  - `book1.jpg`
  - `fiction.png`
  - `science-book.webp`

- **Incorrect formats** (don't use):
  - `C:\xammpp1\htdocs\bookstore\img\book.jpg` (full path)
  - `/bookstore/img/book.jpg`
  - `https://example.com/book.jpg` (external URL)

### Troubleshooting

**Images not showing?**

1. Check `img/` folder exists: `c:\xammpp1\htdocs\bookstore\img\`
2. Verify image filenames match database records
3. Check image format is supported (JPG, PNG, GIF)
4. Ensure image files aren't corrupted

**If image is missing:**

- System will show a placeholder with book title
- This is a fallback - actual images are still preferred

### How Image Display Works

1. Page checks if image file exists
2. If found: displays the actual image
3. If not found: shows SVG placeholder with book title
4. Placeholder helps identify which book is which

### Adding Images to Admin Panel

When you upload a book:

1. Fill book details (title, price, description)
2. Click "Choose File" or "Upload Image"
3. Select image from your computer
4. Click "Add Book"
5. Image is automatically saved to `img/` folder

The system handles everything automatically!
