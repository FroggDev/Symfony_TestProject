<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ArticleType
 * @package App\Form
 */
class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Entity title...',
                        'class' => 'form-control'
                    ]
                ]
            )->add(
                'category',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'label',
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )->add(
                'content',
                TextareaType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Entity content...',
                        'class' => 'form-control'
                    ]
                ]
            )->add(
                'featured_image',
                FileType::class,
                [
                    'data_class' => null,
                    'required' => false,
                    'attr' => [
                        'class' => 'dropify',
                        'data-default-file' => $options['image_url'],
                        'data-allowed-file-extensions' => 'gif jpg jpeg png',
                        'data-max-file-size-preview' => '300K'
                    ]
                ]
            )->add(
                'spotlight',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )->add(
                'special',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Publish',
                    'attr' => array('class' => 'btn btn-primary')
                ]
            )->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'image_url' => null
        ]);
    }
}
