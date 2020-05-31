<?php

namespace Drupal\modulo_teste\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\modulo_teste\Entity\ProdutosInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ProdutosController.
 *
 *  Returns responses for Produtos routes.
 */
class ProdutosController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Produtos revision.
   *
   * @param int $produtos_revision
   *   The Produtos revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($produtos_revision) {
    $produtos = $this->entityTypeManager()->getStorage('produtos')
      ->loadRevision($produtos_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('produtos');

    return $view_builder->view($produtos);
  }

  /**
   * Page title callback for a Produtos revision.
   *
   * @param int $produtos_revision
   *   The Produtos revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($produtos_revision) {
    $produtos = $this->entityTypeManager()->getStorage('produtos')
      ->loadRevision($produtos_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $produtos->label(),
      '%date' => $this->dateFormatter->format($produtos->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Produtos.
   *
   * @param \Drupal\modulo_teste\Entity\ProdutosInterface $produtos
   *   A Produtos object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ProdutosInterface $produtos) {
    $account = $this->currentUser();
    $produtos_storage = $this->entityTypeManager()->getStorage('produtos');

    $langcode = $produtos->language()->getId();
    $langname = $produtos->language()->getName();
    $languages = $produtos->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $produtos->label()]) : $this->t('Revisions for %title', ['%title' => $produtos->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all produtos revisions") || $account->hasPermission('administer produtos entities')));
    $delete_permission = (($account->hasPermission("delete all produtos revisions") || $account->hasPermission('administer produtos entities')));

    $rows = [];

    $vids = $produtos_storage->revisionIds($produtos);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\modulo_teste\ProdutosInterface $revision */
      $revision = $produtos_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $produtos->getRevisionId()) {
          $link = $this->l($date, new Url('entity.produtos.revision', [
            'produtos' => $produtos->id(),
            'produtos_revision' => $vid,
          ]));
        }
        else {
          $link = $produtos->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.produtos.translation_revert', [
                'produtos' => $produtos->id(),
                'produtos_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.produtos.revision_revert', [
                'produtos' => $produtos->id(),
                'produtos_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.produtos.revision_delete', [
                'produtos' => $produtos->id(),
                'produtos_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['produtos_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

  public function listar() {

    $produtos = 'lalalalalal';
    $produtosService = \Drupal::service('modulo_teste.default');
    // var_dump($produtosService->getServiceData());

    return [
      // '#type' => 'markup',
      // '#markup' => '<h1>'.$produtos.'<h1>',
      '#theme' => 'modulo_teste',
      '#data' => $produtosService->getServiceData(),
    ];
  }

}
