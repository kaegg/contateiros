<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Local;
use App\Models\LocalImagem;

class LocalImagemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locais = Local::where('ativo', true)->get();

        if ($locais->isEmpty()) {
            $this->command->info('Nenhum local encontrado. Execute o LocalSeeder primeiro.');
            return;
        }

        // URLs de imagens de exemplo (serão convertidas para Base64)
        $imagensExemplo = [
            'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=400&q=80',
        ];

        foreach ($locais as $index => $local) {
            // Adicionar 2-3 imagens por local
            $numImagens = rand(2, 3);
            
            for ($i = 0; $i < $numImagens; $i++) {
                $imagemUrl = $imagensExemplo[($index + $i) % count($imagensExemplo)];
                
                // Converter URL para Base64 (simulado)
                $base64Image = $this->urlToBase64($imagemUrl);
                
                LocalImagem::updateOrCreate(
                    [
                        'id_local' => $local->id,
                        'imagem' => $base64Image,
                    ],
                    [
                        'ativo' => true,
                    ]
                );
            }
        }

        $this->command->info('Imagens dos locais criadas com sucesso!');
    }

    /**
     * Converte uma URL de imagem para Base64
     * Em produção, você pode usar file_get_contents() ou cURL
     */
    private function urlToBase64($url)
    {
        // Para fins de demonstração, vamos criar um Base64 simulado
        // Em produção, você deve usar:
        // $imageData = file_get_contents($url);
        // return 'data:image/jpeg;base64,' . base64_encode($imageData);
        
        // Base64 simulado de uma imagem pequena
        return 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8A';
    }
} 