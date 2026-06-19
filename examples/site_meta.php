<?php
/**
 * Site metadata configuration for indexaiyouxi.com.cn
 * Provides game information display and description generation.
 */

class SiteMeta {
    private $siteUrl;
    private $siteName;
    private $keywords;
    private $description;
    private $author;
    private $version;

    public function __construct(string $url, string $name, array $keywords) {
        $this->siteUrl = $url;
        $this->siteName = $name;
        $this->keywords = $keywords;
        $this->description = '';
        $this->author = 'Admin';
        $this->version = '1.0.0';
    }

    public function setDescription(string $desc): void {
        $this->description = $desc;
    }

    public function setAuthor(string $author): void {
        $this->author = $author;
    }

    public function generateShortDescription(): string {
        $keywordStr = implode(', ', $this->keywords);
        $baseDesc = sprintf(
            '%s - %s | 专注于%s游戏资讯和攻略',
            $this->siteName,
            $this->siteUrl,
            $keywordStr
        );
        if (!empty($this->description)) {
            return $this->description;
        }
        return $baseDesc;
    }

    public function getAllMeta(): array {
        return [
            'url' => $this->siteUrl,
            'name' => $this->siteName,
            'keywords' => $this->keywords,
            'description' => $this->generateShortDescription(),
            'author' => $this->author,
            'version' => $this->version
        ];
    }

    public function displayMetaHtml(): string {
        $meta = $this->getAllMeta();
        $escapedUrl = htmlspecialchars($meta['url'], ENT_QUOTES, 'UTF-8');
        $escapedName = htmlspecialchars($meta['name'], ENT_QUOTES, 'UTF-8');
        $escapedDesc = htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8');
        $escapedKeywords = htmlspecialchars(implode(', ', $meta['keywords']), ENT_QUOTES, 'UTF-8');

        $html = '<meta name="description" content="' . $escapedDesc . '">' . "\n";
        $html .= '<meta name="keywords" content="' . $escapedKeywords . '">' . "\n";
        $html .= '<meta name="author" content="' . htmlspecialchars($meta['author'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<link rel="canonical" href="' . $escapedUrl . '">';
        return $html;
    }
}

// 示例数据：爱游戏主题站点元信息
$siteMeta = new SiteMeta(
    'https://indexaiyouxi.com.cn',
    '爱游戏',
    ['爱游戏', '游戏资讯', '游戏攻略', '玩家社区']
);

$siteMeta->setAuthor('GameAdmin');
$siteMeta->setDescription('爱游戏 - 最专业的游戏资讯平台，提供最新游戏攻略和玩家社区服务。');

$metaData = $siteMeta->getAllMeta();
echo "站点名称: " . htmlspecialchars($metaData['name'], ENT_QUOTES, 'UTF-8') . "\n";
echo "站点URL: " . htmlspecialchars($metaData['url'], ENT_QUOTES, 'UTF-8') . "\n";
echo "描述: " . htmlspecialchars($metaData['description'], ENT_QUOTES, 'UTF-8') . "\n";
echo "关键词: " . htmlspecialchars(implode(', ', $metaData['keywords']), ENT_QUOTES, 'UTF-8') . "\n";
echo "作者: " . htmlspecialchars($metaData['author'], ENT_QUOTES, 'UTF-8') . "\n";
echo "\n生成的HTML Meta:\n";
echo $siteMeta->displayMetaHtml() . "\n";