<?php
namespace App\Controller;

use App\Entity\Article;
use App\Service\Article\ArticleCatalog;
use App\SiteConfig;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends Controller
{
    /**
     * @Route(
     *      "/{_locale}/wordcloud/{search}/{currentPage}.html",
     *      name="wordcloud_search",
     *      requirements={"currentPage" : "\d+"},
     *      defaults={"currentPage"="1"},
     *      methods={"GET"}
     * )
     *
     * @param string $search
     * @param string $currentPage
     * @return Response
     */
    public function wordTag(string $search, string $currentPage, ArticleCatalog $catalog): Response
    {
        # FROM DOCTRINE
        /*
        # get repo category
        $repositoryArticle = $this->getDoctrine()->getRepository(Article::class);

        # get category from category
        $articles = $repositoryArticle->findAll();
        */

        # FROM CATALOG
        $articles = $catalog->findAll()->toArray();

        # search in array
        $matches = array_filter(
            $articles,
            function ($article) use ($search) {
                return (
                    preg_match("/\b$search\b/i", $article->getTitle())
                    ||
                    preg_match("/\b$search\b/i", $article->getContent())
                );
            }
        );

        # get number of elenmts
        $countArticle =count($matches);

        # get only wanted articles
        $articles = array_slice($matches, ($currentPage-1) * SiteConfig::NBARTICLEPERPAGE, SiteConfig::NBARTICLEPERPAGE);

        # number of pagination
        $countPagination =  ceil($countArticle / SiteConfig::NBARTICLEPERPAGE);

        # display page from twig template
        return $this->render('index/search.html.twig', [
            'articles' => $articles,
            'search' => $search,
            'currentPage' => $currentPage,
            'searchType' => 'wordcloud',
            'countPagination' => $countPagination
        ]);
    }


    /**
     * @Route(
     *      "/{_locale}/search/{search}/{currentPage}.html",
     *      name="index_search",
     *      requirements={"currentPage" : "\d+"},
     *      defaults={"currentPage"="1"},
     *      methods={"GET"}
     * )
     *
     * @param string $search
     * @param string $currentPage
     * @return Response
     */
    public function search(string $search, string $currentPage, ArticleCatalog $catalog): Response
    {
        # FROM DOCTRINE
        /*
        # get repo category
        $repositoryArticle = $this->getDoctrine()->getRepository(Article::class);

        # get category from category
        $articles = $repositoryArticle->findAll();
        */

        # FROM CATALOG
        $articles = $catalog->findAll()->toArray();

        # search in array
        $matches = array_filter(
            $articles,
            function ($article) use ($search) {
                return (
                    preg_match("/$search/i", $article->getTitle())
                    ||
                    preg_match("/$search/i", $article->getContent())
                );
            }
        );

        # get number of elenmts
        $countArticle =count($matches);

        # get only wanted articles
        $articles = array_slice($matches, ($currentPage-1) * SiteConfig::NBARTICLEPERPAGE, SiteConfig::NBARTICLEPERPAGE);

        # number of pagination
        $countPagination =  ceil($countArticle / SiteConfig::NBARTICLEPERPAGE);

        # display page from twig template
        return $this->render('index/search.html.twig', [
            'articles' => $articles,
            'search' => $search,
            'currentPage' => $currentPage,
            'searchType' => 'index',
            'countPagination' => $countPagination
        ]);
    }

    /**
     * @Route(
     *      "/{_locale}/last/{currentPage}.html",
     *      name="last_article",
     *      requirements={"currentPage" : "\d+"},
     *      defaults={"currentPage"="1"},
     *      methods={"GET"}
     * )
     *
     * @param string $currentPage
     * @return Response
     */
    public function lastArticle(string $currentPage, ArticleCatalog $catalog): Response
    {
        # FROM DOCTRINE
        /*
        # get repo category
        $repositoryArticle = $this->getDoctrine()->getRepository(Article::class);

        # get category from category
        $articles = $repositoryArticle->findAll();
        */

        # FROM CATALOG
        $articles = $catalog->findAll()->toArray();

        # get number of elenmts
        $countArticle =count($articles);

        # get only wanted articles
        $articles = array_slice($articles, ($currentPage-1) * SiteConfig::NBARTICLEPERPAGE, SiteConfig::NBARTICLEPERPAGE);

        # number of pagination
        $countPagination =  ceil($countArticle / SiteConfig::NBARTICLEPERPAGE);

        # display page from twig template
        return $this->render('index/last.html.twig', [
            'articles' => $articles,
            'currentPage' => $currentPage,
            'countPagination' => $countPagination
        ]);
    }
}
