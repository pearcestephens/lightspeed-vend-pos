<?php

namespace App\Repositories;

use App\Models\73;
use Illuminate\Database\Eloquent\Collection;

class 73Repository {

    public function findById($id): ?73 {
        return 73::find($id);
    }

    public function getAll(): Collection {
        return 73::all();
    }

    public function create(array $data): 73 {
        return 73::create($data);
    }

    public function update($id, array $data): bool {
        return 73::find($id)->update($data);
    }

    public function delete($id): bool {
        return 73::destroy($id) > 0;
    }
}