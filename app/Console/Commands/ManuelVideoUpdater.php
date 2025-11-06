<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Models\User;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManuelVideoUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manuel:video-updater';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Video güncelleme işlemi başlatılıyor...');

        $disk = Storage::disk('manuel-videos');
        $files = $disk->allFiles();

        $this->info('Toplam ' . count($files) . ' dosya bulundu.');

        // Dosyaları klasörlere göre grupla
        $groupedFiles = collect($files)->groupBy(function ($file) {
            return dirname($file); // Klasör ismini al
        });

        foreach ($groupedFiles as $folderName => $filesInFolder) {
            $this->line('Klasör işleniyor: ' . $folderName);

            // Channel'ı bul veya oluştur
			$channel = Channel::where('name', $folderName)->first();
			if (!$channel) {
				$user = User::create([
					'name' => $folderName,
					'email' => Str::slug($folderName) . '@example.com',
					'password' => bcrypt('password'), // Güvenlik için gerçek bir parola kullanın
				]);
                $channel = Channel::create([
                        'user_id' => $user->id,
						'uid' => Str::uuid(),
                        'name' => $folderName,
                        'slug' => Str::slug($folderName),
                        'description' => 'Otomatik oluşturuldu: ' . $folderName,
                        // Diğer gerekli alanları buraya ekleyin
                    ]);
				$this->info('  ✓ Yeni channel oluşturuldu: ' . $folderName);

			} else {
				$this->info('  ✓ Mevcut channel bulundu: ' . $folderName);
			}

            // Bu klasördeki her dosya için işlem yap
            foreach ($filesInFolder as $file) {
				// Dosya uzantısını kontrol et
				$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				$allowedExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'm4v'];
				
				if (!in_array($extension, $allowedExtensions)) {
					$this->warn('  ⊘ Video dosyası değil, es geçiliyor: ' . basename($file));
					continue;
				}
				
                $this->line('  - Video işleniyor: ' . basename($file));
				
				// $file zaten 'Niloya/1-bolu.mov' şeklinde tam path içeriyor
				$fileExists = Storage::disk('manuel-videos')->exists($file);
				$this->info('  Dosya var mı? ' . ($fileExists ? 'Evet' : 'Hayır'));
				
				if (!$fileExists) {
					$this->error('  Dosya bulunamadı: ' . $file);
					continue;
				}
				
				// Dosya hash'ini hesapla
				$fullPath = Storage::disk('manuel-videos')->path($file);
				$fileHash = hash_file('sha256', $fullPath);
				// Hash'e göre kontrol et
				$existingVideo = Video::where('file_hash', $fileHash)->first();
				if ($existingVideo) {
					$this->info('  ⊘ Video zaten var (hash eşleşti), es geçiliyor...');
					continue;
				}

				// Dosyayı al veya path'i kullan

				$diskPath = 'storage/app/public/manuel-videos/' . $file;
				$fileName = basename($file); // '1-bolu.mov'
				
				// $videoPath = app(VideoService::class)->uploadVideoToStorage(
				// 	$fullPath
				// );
				$title = Str::beforeLast($fileName, '[');
				$title = Str::beforeLast($title, '.');

				$video = app(VideoService::class)
					->saveVideoToDatabase($channel->uid, $diskPath, [
						'title' =>  $title,
						'description' => null,
						'visibility' => "public",
						'file_hash' => $fileHash,
					],
					config('app.url') . '/storage/manuel-videos/' . $file
				);

				app(VideoService::class)->generateThumbnail($video, 'manuel-videos');
				
				$this->info('  ✓ Video başarıyla eklendi');
			}
        }

        $this->info('İşlem tamamlandı!');

        return Command::SUCCESS;
    }
}
