<?php

namespace App\Services;

use Phpml\Classification\NaiveBayes;

class SentimentAnalysis
{
    public static function analiyseRespose($text)
    {
        // Define training data
        $samples = [
            ["I love this product"],
            ["It is amazing"],
            ["So bad experience"],
            ["I hate it"],
            ["Neutral response"],
            ["Very good"],
            ["Fake items"],
            ["Poor Customer Service"],
            ["Great work"],
            ["Very bad"],
        ];

            // Ensure labels match the number of samples
        $labels = [
            'positive', 'positive', 'negative', 'negative', 'neutral',
            'positive', 'negative', 'negative', 'positive', 'negative'
        ];

        $classifier = new NaiveBayes();
        $classifier->train($samples, $labels);

        return $classifier->predict([$text]);
    }

}