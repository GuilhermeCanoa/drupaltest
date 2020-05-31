<?php

namespace Drupal\modulo_teste\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Produtos revision.
 *
 * @ingroup modulo_teste
 */
class ProdutosRevisionDeleteForm extends ConfirmFormBase {

  /**
   * The Produtos revision.
   *
   * @var \Drupal\modulo_teste\Entity\ProdutosInterface
   */
  protected $revision;

  /**
   * The Produtos storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $produtosStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->produtosStorage = $container->get('entity_type.manager')->getStorage('produtos');
    $instance->connection = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'produtos_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the revision from %revision-date?', [
      '%revision-date' => format_date($this->revision->getRevisionCreationTime()),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.produtos.version_history', ['produtos' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $produtos_revision = NULL) {
    $this->revision = $this->ProdutosStorage->loadRevision($produtos_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->ProdutosStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Produtos: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addMessage(t('Revision from %revision-date of Produtos %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.produtos.canonical',
       ['produtos' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {produtos_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.produtos.version_history',
         ['produtos' => $this->revision->id()]
      );
    }
  }

}
