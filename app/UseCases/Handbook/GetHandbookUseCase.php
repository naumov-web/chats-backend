<?php

namespace App\UseCases\Handbook;

use App\Models\Handbook\Contracts\IHandbookService;
use App\Models\Handbook\DTO\HandbookDTO;
use App\UseCases\BaseUseCase;

/**
 * Class GetHandbookUseCase
 * @package App\UseCases\Handbook
 */
final class GetHandbookUseCase extends BaseUseCase
{
    /**
     * Output DTO instance
     * @var HandbookDTO
     */
    private HandbookDTO $outputDto;

    /**
     * GetHandbookUseCase constructor
     * @param IHandbookService $service
     */
    public function __construct(private IHandbookService $service) {}

    /**
     * Get output DTO instance
     *
     * @return HandbookDTO
     */
    public function getOutputDto(): HandbookDTO
    {
        return $this->outputDto;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->outputDto = $this->service->getHandbook();
    }
}
