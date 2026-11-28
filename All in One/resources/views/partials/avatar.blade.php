@php
    $name = $name ?? 'Pengguna';
    $avatar = $avatar ?? null;
    $size = $size ?? 'w-9 h-9';
    $textSize = $textSize ?? 'text-xs';
    $classExtra = $classExtra ?? '';
    
    // Generate clean 1-2 letter uppercase initials
    $words = preg_split("/\s+/", trim($name));
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    $initials = $initials ?: 'U';

    // Color palette based on name hash for unique, consistent, pleasant colors
    $palette = [
        ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'border' => 'border-indigo-200'],
        ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
        ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'border' => 'border-sky-200'],
        ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'border' => 'border-purple-200'],
        ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'border' => 'border-rose-200'],
        ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200'],
        ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'border' => 'border-teal-200'],
        ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'border' => 'border-blue-200'],
    ];
    $color = $palette[abs(crc32($name)) % count($palette)];

    // Check if avatar is a real uploaded photo (not the placeholder avatar-*.png)
    $isPlaceholder = empty($avatar) || str_contains($avatar, 'avatar-');
    $hasPhoto = !$isPlaceholder && (
        str_starts_with($avatar, 'data:') || 
        str_starts_with($avatar, 'http') || 
        file_exists(public_path($avatar))
    );
@endphp

@if($hasPhoto)
    <img src="{{ str_starts_with($avatar, 'data:') || str_starts_with($avatar, 'http') ? $avatar : asset($avatar) }}" 
         alt="{{ $name }}" 
         class="{{ $size }} rounded-full object-cover border border-gray-100 shrink-0 {{ $classExtra }}"
         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';">
    <div class="{{ $size }} rounded-full {{ $color['bg'] }} {{ $color['text'] }} font-bold {{ $textSize }} flex items-center justify-center shrink-0 border {{ $color['border'] }} {{ $classExtra }}" style="display:none;">
        {{ $initials }}
    </div>
@else
    <div class="{{ $size }} rounded-full {{ $color['bg'] }} {{ $color['text'] }} font-bold {{ $textSize }} flex items-center justify-center shrink-0 border {{ $color['border'] }} {{ $classExtra }}" title="{{ $name }}">
        {{ $initials }}
    </div>
@endif
