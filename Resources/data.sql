
TRUNCATE `feeds` IF EXISTS;
INSERT INTO `feeds` (name, url, rate, frequency) VALUES
('BBC Football', 'http://newsrss.bbc.co.uk/rss/sportplayer_uk_edition/football/rss.xml', 1, 'd'),
('Caught Off Side', 'http://www.caughtoffside.com/feed/rss/', 1, 'd'),
('Manchester United', 'http://www.manutd.com/rss', 1, 'd'),
('Sky Sports', 'http://www.skysports.com/rss/0,20514,11688,00.xml', 1, 'd'),
('Sky Sports', 'http://www.skysports.com/rss/0,20514,11945,00.xml', 1, 'd'),
('Sky Sports', 'http://www.skysports.com/rss/0,20514,11661,00.xml', 1, 'd'),
('Scores Pro', 'http://www.scorespro.com/rss/live-soccer.xml', 1, 'd'),
('Guardian Football', 'http://feeds.guardian.co.uk/theguardian/football/rss', 1, 'd'),
('The Spoiler', 'http://www.thespoiler.co.uk/index.php/feed', 1, 'd'),
('UK Express', 'http://uk.express.feedsportal.com/c/33338/f/565864/index.rss', 1, 'd') ;
