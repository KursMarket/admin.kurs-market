<?php
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

function generateHumanNewsType(News $news): string
{
    $type = "Новость";
    switch ($news->type_id) {
        case News::ARTICLE:
            $type = 'Статья';
            break;
        case News::NEWS:
            $type = 'Новость';
            break;
    }

    return $type;
}

function generateHumanDate(?string $date): string
{
    return Carbon::parse($date)->format('d.m.Y');
}

function checkVisibleForAttribute(News $news, string $key): bool
{
    if ($news->visible_for) {

        if (!canBeUnSerialized($news->visible_for)) {
            return false;
        }
        $visibleFor = unserialize($news->visible_for);

        if (null === $visibleFor) {
            return false;
        }

        if (gettype($visibleFor) === 'string') {
            return Str::lower($visibleFor) === Str::lower($key);
        }

        return in_array($key, $visibleFor);
    }

    return false;
}

function getHumanVisibleAttribute(News $news) : string
{
    if ($news->visible_for) {
        $allLevels = News::getArticlesLevels();

        if (!canBeUnSerialized($news->visible_for)) {
            return $allLevels[$news->visible_for];
        }
        $visibleFor = unserialize($news->visible_for);

        if (null === $visibleFor) {
            return "";
        }

        if (gettype($visibleFor) === 'string') {

            return $visibleFor;
        }

        $data = [];

        foreach ($visibleFor as $v) {
            $data[] = $allLevels[$v];
        }

        return implode(", ", $data);
    }
    return "";
}

function canBeUnSerialized($string): bool {
    if (@unserialize($string) === false) {
        return false;
    }
    return true;
}

function transformRequest(Request $request): array {
    return array_map(function ($req) {
        if ($req === "null") {
            $req = null;
        }

        if ($req === "true") {
            $req = true;
        }

        if ($req === "false") {
            $req = false;
        }
        return $req;
    }, $request->all());
}
