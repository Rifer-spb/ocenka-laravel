import Button from "@common/components/form/Button";
import {IInviteTab} from "@manager/components/invite/types";

type Props = {
    id: number;
    currentTab: IInviteTab;
    handleReSend: Function;
    handleCancel: Function;
    handleConfirm: Function;
}

export default function ({ id, currentTab, handleReSend, handleCancel, handleConfirm } : Props) {
    return (
        <>
            <div className="btn-group">
                {currentTab.id == 'inbox' ? (
                    <>
                        <Button
                            type="button"
                            onClick={() => handleCancel(id)}
                        >Отклонить</Button>
                        <Button
                            type="button"
                            className="btn-success"
                            onClick={() => handleConfirm(id)}
                        >Подтвердить</Button>
                    </>
                ) : currentTab.id == 'outbox' ? (
                    <>
                        <Button
                            type="button"
                            className="btn-success"
                            onClick={() => handleReSend(id)}
                        >Повторить</Button>
                        <Button
                            type="button"
                            onClick={() => handleCancel(id)}
                        >Отозвать</Button>
                    </>
                ) : ''}
            </div>
        </>
    );
}
