<?php

namespace App\Repositories;

use App\Models\54;
use Illuminate\Database\Eloquent\Collection;

class 54Repository {

    public function findById($id): ?54 {
        return 54::find($id);
    }

    public function getAll(): Collection {
        return 54::all();
    }

    public function create(array $data): 54 {
        return 54::create($data);
    }

    public function update($id, array $data): bool {
        return 54::find($id)->update($data);
    }

    public function delete($id): bool {
        return 54::destroy($id) > 0;
    }
}