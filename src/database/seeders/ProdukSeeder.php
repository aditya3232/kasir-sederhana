<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            ['kode' => 'PRD-001', 'nama' => 'Kopi Arabika 250g', 'deskripsi' => 'Kopi arabika khas Gayo Aceh', 'harga' => 350000, 'stok' => 50, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-002', 'nama' => 'Kopi Robusta 250g', 'deskripsi' => 'Kopi robusta khas Gayo Aceh', 'harga' => 250000, 'stok' => 50, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-003', 'nama' => 'Kopi Gayo Natural 250g', 'deskripsi' => 'Kopi gayo proses natural', 'harga' => 275000, 'stok' => 40, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-004', 'nama' => 'Kopi Gayo Honey 250g', 'deskripsi' => 'Kopi gayo proses honey', 'harga' => 285000, 'stok' => 35, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-005', 'nama' => 'Kopi Toraja 250g', 'deskripsi' => 'Kopi toraja body tebal', 'harga' => 300000, 'stok' => 25, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-006', 'nama' => 'Kopi Flores Bajawa 250g', 'deskripsi' => 'Kopi flores aroma floral', 'harga' => 310000, 'stok' => 18, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-007', 'nama' => 'Kopi Java Preanger 250g', 'deskripsi' => 'Kopi java rasa seimbang', 'harga' => 265000, 'stok' => 60, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-008', 'nama' => 'Kopi Mandailing 250g', 'deskripsi' => 'Kopi mandailing earthy', 'harga' => 295000, 'stok' => 12, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-009', 'nama' => 'Kopi Kintamani 250g', 'deskripsi' => 'Kopi kintamani citrus', 'harga' => 320000, 'stok' => 8, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-010', 'nama' => 'Kopi Lampung Robusta 500g', 'deskripsi' => 'Robusta lampung kemasan besar', 'harga' => 180000, 'stok' => 100, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-011', 'nama' => 'Kopi Luwak Blend 100g', 'deskripsi' => 'Blend premium', 'harga' => 450000, 'stok' => 5, 'aktif' => true, 'catatan' => 'Stok terbatas'],
            ['kode' => 'PRD-012', 'nama' => 'Kopi Decaf 250g', 'deskripsi' => 'Kopi rendah kafein', 'harga' => 340000, 'stok' => 0, 'aktif' => false, 'catatan' => 'Menunggu restock'],
            ['kode' => 'PRD-013', 'nama' => 'Biji Kopi Espresso 1kg', 'deskripsi' => 'Roast medium-dark untuk espresso', 'harga' => 390000, 'stok' => 30, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-014', 'nama' => 'Kopi Bubuk Tubruk 200g', 'deskripsi' => 'Kopi bubuk halus untuk tubruk', 'harga' => 55000, 'stok' => 150, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-015', 'nama' => 'Kopi Sachet Latte (10 pcs)', 'deskripsi' => 'Kopi instan latte', 'harga' => 45000, 'stok' => 200, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-016', 'nama' => 'Kopi Sachet Mocha (10 pcs)', 'deskripsi' => 'Kopi instan mocha', 'harga' => 45000, 'stok' => 9, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-017', 'nama' => 'Gula Aren Cair 500ml', 'deskripsi' => 'Pemanis alami', 'harga' => 38000, 'stok' => 70, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-018', 'nama' => 'Filter Kertas V60 (100 pcs)', 'deskripsi' => 'Kertas filter ukuran 02', 'harga' => 42000, 'stok' => 45, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-019', 'nama' => 'Dripper V60 Keramik', 'deskripsi' => 'Dripper keramik warna putih', 'harga' => 125000, 'stok' => 15, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-020', 'nama' => 'Gelas Takar Kopi 600ml', 'deskripsi' => 'Gelas ukur kaca', 'harga' => 65000, 'stok' => 22, 'aktif' => false, 'catatan' => 'Produk dihentikan'],
            ['kode' => 'PRD-021', 'nama' => 'Grinder Manual Stainless', 'deskripsi' => 'Penggiling kopi manual', 'harga' => 380000, 'stok' => 7, 'aktif' => true, 'catatan' => null],
            ['kode' => 'PRD-022', 'nama' => 'Tumbler Kopi 350ml', 'deskripsi' => 'Tumbler stainless tahan panas', 'harga' => 95000, 'stok' => 3, 'aktif' => true, 'catatan' => null],
        ];

        foreach ($produk as $item) {
            Produk::updateOrCreate(
                ['kode' => $item['kode']], // kunci pencarian
                $item                      // data yang disimpan/diperbarui
            );
        }
    }
}