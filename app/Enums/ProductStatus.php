<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Discovered = 'discovered';
    case Watching = 'watching';
    case PreTest = 'pre_test';
    case Testing = 'testing';
    case Winner = 'winner';
    case Ordered = 'ordered';
    case Received = 'received';
    case RealReview = 'real_review';
    case Scaling = 'scaling';
    case Rejected = 'rejected';
    case Archived = 'archived';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public function permitsRealExperience(): bool
    {
        return in_array($this, [self::Received, self::RealReview, self::Scaling], true);
    }

    public function canEnterMainOpportunity(): bool
    {
        return ! in_array($this, [self::Rejected, self::Archived], true);
    }
}
