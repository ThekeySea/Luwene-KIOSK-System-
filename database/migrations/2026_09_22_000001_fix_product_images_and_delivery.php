<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $images = [
            'ayam-goreng-luwene' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400&h=300&fit=crop',
            'ayam-bakar-madu' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=400&h=300&fit=crop',
            'ayam-geprek' => 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=400&h=300&fit=crop',
            'sate-ayam' => 'https://images.unsplash.com/photo-1529563021893-cc83c992d75d?w=400&h=300&fit=crop',
            'rendang-sapi' => 'https://images.unsplash.com/photo-1545247181-516773cae754?w=400&h=300&fit=crop',
            'empal-goreng' => 'https://images.unsplash.com/photo-1607167986504-6e1d0f7e1a2b?w=400&h=300&fit=crop',
            'sate-sapi' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop',
            'lele-goreng' => 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?w=400&h=300&fit=crop',
            'nila-bakar' => 'https://images.unsplash.com/photo-1534766555764-ce878a857731?w=400&h=300&fit=crop',
            'udang-crispy' => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=400&h=300&fit=crop',
            'cumi-goreng-tepung' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=300&fit=crop',
            'sambal-bawang' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=400&h=300&fit=crop',
            'sambal-terasi' => 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&h=300&fit=crop',
            'sambal-ijo' => 'https://images.unsplash.com/photo-1472476443507-c7a5948772fc?w=400&h=300&fit=crop',
            'sambal-matah' => 'https://images.unsplash.com/photo-1596591868231-05e787b82b4c?w=400&h=300&fit=crop',
            'kentang-goreng' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=400&h=300&fit=crop',
            'tahu-isi' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=300&fit=crop',
            'tempe-mendoan' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=300&fit=crop',
            'pisang-goreng-coklat-keju' => 'https://images.unsplash.com/photo-1528207776546-365bb710ee93?w=400&h=300&fit=crop',
            'es-teh-manis' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=300&fit=crop',
            'es-jeruk-segar' => 'https://images.unsplash.com/photo-1621263764928-df1444c5e859?w=400&h=300&fit=crop',
            'teh-hangat' => 'https://images.unsplash.com/photo-1571934811356-5cc061b6201f?w=400&h=300&fit=crop',
            'kopi-tubruk' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=400&h=300&fit=crop',
        ];

        foreach ($images as $slug => $url) {
            DB::table('products')->where('slug', $slug)->update([
                'image' => $url,
                'is_published_delivery' => true,
            ]);
        }

        DB::table('products')->where('is_active', true)->update([
            'is_published_delivery' => true,
        ]);
    }
};
